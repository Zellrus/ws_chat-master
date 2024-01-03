<template>
    <authenticated-layout>
        <Head :title="  chat.title ?? 'Ваш чат' " />
        <Link :href="route('chats.index')" class="btn btn-outline-secondary">Вернуться назад</Link>
        <div class="row align-items-start">
            <div class="col-8">
                <div class="fs-4 text-center">{{  chat.title ?? 'Ваш чат' }}</div>
        <div class="w-3/4 p-4 mr-4 bg-white border border-gray-200 message_box">
            <div ref="message_box" class="mb-4" v-if="messages">
                <div v-if="!isLastPage" class="text-center mb-2">
                    <a @click.prevent="getMessages"
                       class="btn " href="#">Читать дальше</a>
                </div>
                <div v-for="message in messages.slice().reverse()" :class="message.is_owner ? ' text-end': ''">
                    <div :class="['', message.is_owner ? 'chat-block border border-success ': ' chat-block border border-secondary']">
                        <div class="message">
                        <p class="text-sm message">{{ message.user_name }}</p>
                        </div>
                        <p class="mb-2">{{ message.body }}</p>
                        <p class="text-xs italic">{{ message.time }}</p>
                    </div>
                </div>
            </div>
        </div>
                        <textarea @keyup.enter.prevent="handleEnterKey" placeholder="Ваше сообщение" class="form-control" type="text" v-model="body"></textarea>
                        <a @click.prevent="store" class="btn btn-secondary" href="#">Отправить</a>

        </div>
        <div class="col">
            <div v-if="users">
                <ul v-for="user in users" class="list-group ">
                    <li class="list-group-item">{{ user.name }}</li>
                </ul>
                <Picker :data="emojiIndex" set="apple" @select="showEmoji" />
            </div>

            </div>
        </div>

    </authenticated-layout>
</template>

<script>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {Head, Link} from '@inertiajs/vue3';

import data from "emoji-mart-vue-fast/data/all.json";
// Import default CSS
import "emoji-mart-vue-fast/css/emoji-mart.css";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast/src";
let emojiIndex = new EmojiIndex(data);
export default {
    name: "Show",
    components: {Head, InputLabel, AuthenticatedLayout, Link,Picker},

    props: [
        'chat',
        'users',
        'messages',
        'isLastPage'
    ],

    created() {
        window.Echo.channel(`store-message.${this.chat.id}`)
            .listen('.store-message', res => {
                this.messages.unshift(res.message)
                if (this.$page.url === `/chats/${this.chat.id}`
                ) {
                    axios.patch('/message_statuses', {
                        message_id: res.message.id,
                        user_id: this.$page.props.auth.user.id
                    })
                    .catch( error => {

                    });
                }
            })

    },

    data() {
        return {
            body: '',
            page: 1,
            emojiIndex: emojiIndex,
            emojisOutput: ""
        }
    },


    computed: {
        userIds() {
            return this.users.map(user => {
                return user.id
            }).filter(userId => {
                return userId !== this.$page.props.auth.user.id
            })
        },
    },


    methods: {
        showEmoji(emoji) {
            this.body = this.body + (this.emojisOutput + emoji.native);
        },
        handleEnterKey(event) {
            if (!event.shiftKey) {
                this.store();
            }
        },

        store() {
            axios.post('/messages', {
                chat_id: this.chat.id,
                body: this.body,
                user_ids: this.userIds
            })
                .then(res => {
                    this.messages.unshift(res.data)
                    this.body = ''
                })
        },

        getMessages() {
            axios.get(`/chats/${this.chat.id}?page=${++this.page}`)
                .then(res => {
                    this.messages.push(...res.data.messages)
                    this.$page.props.isLastPage = res.data.is_last_page
                })
        },
    }

}
</script>

<style scoped>
.chat-block{
    border: 1px solid red;
    display: inline-block;
    padding: 10px;
    margin-bottom: 15px;
}
.message {
    display: block;
    margin-bottom: 10px;
}
.message_box {
    overflow-y: auto ;
    height: 770px;
}
</style>
