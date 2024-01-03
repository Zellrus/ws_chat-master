<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <Link class="navbar-brand" href="/">WS чат</Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <Link class="nav-link" aria-current="page" :href="route('chats.index')">Список чатов</Link>
                    </li>
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="#">Друзья</a>-->
<!--                    </li>-->
                    <span class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $page.props.auth.user.name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><DropdownLink class="dropdown-item" :href="route('profile.edit')">Профиль</DropdownLink></li>
                            <li><DropdownLink class="dropdown-item" :href="route('logout')" method="post" as="button">Выйти</DropdownLink></li>

                        </ul>
                    </span>
                </ul>
            </div>
        </div>
    </nav>
            <main class="container">
                <slot />
            </main>

</template>
