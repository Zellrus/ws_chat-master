<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <Link class="navbar-brand" href="/">WS чат</Link>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <Link class="nav-link" aria-current="page" href="/">Главная</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('login')">Вход</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('register')">Регистрация</Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

        <div class="container">
            <slot />
        </div>
    </div>
</template>
