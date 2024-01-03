<template>

    <authenticated-layout>
        <Head title="Чат" />
        <div class="">
            <div class="row align-items-start">
                <div class="col">
                    <div class="">
                        <h3 class="">Сообщения</h3>
                        <div>
                            <ul class="list-group">
                                <li class="list-group-item" :style="[chat.unreadable_count !== 0 ? 'background-color: #87cefa;' : '']" v-for="chat in chats">
                                    <Link :href="route('chats.show', chat.id)" class="text-body text-decoration-none">
                                    <p class="fw-bold">{{ chat.title }}</p>
                                    <div class="row align-items-start">
                                        <div class="col">

                                        </div>
                                        <div class="col">
                                            <div>{{ chat.last_message.user_name }}</div>
                                            <div>{{ chat.last_message.body }}
                                                <span v-if="chat.unreadable_count !== 0" class="badge bg-danger float-end">{{chat.unreadable_count}}</span>
                                             {{ chat.last_message.time }} </div>
                                        </div>
                                    </div>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row align-items-start">
                        <div v-if="friends" class="col">
                            <div v-if="friends" class="">
                                <h3 class="">Друзья</h3>
                                <div v-if="friends" class="">
                                    <a v-if="!isGroup" @click.prevent="isGroup = true" href="#" class="btn btn-secondary">Создать группу</a>
                                    <div v-if="isGroup" class="">
                                        <input class="" type="" placeholder=""
                                               v-model="title">
                                        <a @click.prevent="storeGroup"
                                           :class="['', this.userIds.length > 1 ? 'btn btn-info' : 'btn btn-outline-info disabled']" href="#">Перейти в чат</a>
                                        <a @click.prevent="refreshUserIds" class="btn btn-outline-danger" href="#">X</a>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" v-for="friend in friends">
                                        <p class="mr-4">{{ friend.name }}</p>
                                        <a @click.prevent="store(friend.id)" class="btn" href="#">Перейти к сообщениям</a>
                                        <a @click.prevent="removeFriend(friend.id)" class="btn" href="#">Удалить из друзей</a>
                                        <div v-if="isGroup">
                                            <input @click="toggleUsers(friend.id)" type="checkbox">
                                        </div>
                                    </li>

                                </ul>
                    </div>
                        </div>
                        <div class="col">
                            <div v-if="users" class="">
                                <h3 class="">Пользователи</h3>
                                <div class="">
                                    <a v-if="!isGroup" @click.prevent="isGroup = true" href="#" class="btn btn-secondary">Создать группу</a>
                                    <div v-if="isGroup" class="">
                                        <input class="" type="" placeholder=""
                                               v-model="title">
                                        <a @click.prevent="storeGroup"
                                           :class="['', this.userIds.length > 1 ? 'btn btn-info' : 'btn btn-outline-info disabled']" href="#">Перейти в чат</a>
                                        <a @click.prevent="refreshUserIds" class="btn btn-outline-danger" href="#">X</a>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" v-for="user in users">
                                            <p class="mr-4">{{ user.name }}</p>
                                            <a @click.prevent="store(user.id)" class="btn" href="#">Перейти к сообщениям</a>
                                            <a @click.prevent="addFriend(user.id)" class="btn" href="#">Добавить в друзья</a>
                                            <div v-if="isGroup">
                                                <input @click="toggleUsers(user.id)" type="checkbox">
                                            </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </authenticated-layout>
</template>

<script>
import {Head, Link} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Show from "@/Pages/Chat/Show.vue";


export default {
    name: "Index",

    props: [
        'users',
        'chats',
        'friends'
    ],

    data() {
        return {
            isGroup: false,
            userIds: [],
            title: null
        }
    },

    created() {
        window.Echo.private(`users.${this.$page.props.auth.user.id}`)
            .listen('.store-message-status', res => {
                this.chats.filter(chat => {
                    if (chat.id === res.chat_id) {
                        chat.unreadable_count = res.count
                        chat.last_message = res.message
                    }
                })
            })
    },

    components: {
        Head,
        Link,
        AuthenticatedLayout,
        Show,
    },


    methods: {

        store(id) {
            this.$inertia.post('/chats', {title: null, users: [id]})
        },
        addFriend(id){
            this.$inertia.post(`/friends/${id}`)
        },
        removeFriend(id){
            this.$inertia.delete(`/friends/${id}`)
        },
        storeGroup() {
            if (this.userIds.length < 2) return
            this.$inertia.post('/chats', {title: this.title, users: this.userIds})
        },

        toggleUsers(id) {
            let index = this.userIds.indexOf(id)
            if (index === -1) {
                this.userIds.push(id)
            } else {
                this.userIds.splice(index, 1)
            }
        },
        refreshUserIds() {
            this.userIds = []
            this.isGroup = false
        },

    }

}
</script>

<style scoped>

</style>
