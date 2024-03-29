<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { computed } from 'vue'

// Component
import Cart from "@/Components/Cart.vue";

const categories = computed(() => usePage().props.value.categories)
</script>

<template>
    <div class="relative overflow-hidden bg-white min-h-screen">
        <div class="mx-auto max-w-7xl">
            <div class="relative z-10 bg-white pb-8 sm:pb-16 md:pb-20 lg:w-full lg:max-w-2xl lg:pb-28 xl:pb-32">
                <svg class="absolute inset-y-0 right-0 hidden h-full w-48 translate-x-1/2 transform text-white lg:block"
                    fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <Popover>
                    <div class="relative px-4 pt-6 sm:px-6 lg:px-8">
                        <nav class="relative flex items-center justify-between sm:h-10 lg:justify-start"
                            aria-label="Global">
                            <div class="flex flex-shrink-0 flex-grow items-center lg:flex-grow-0">
                                <div class="flex w-full items-center justify-between md:w-auto">
                                    <a href="#">
                                        <span class="sr-only">Your Company</span>
                                        <img alt="Your Company" class="h-8 w-auto sm:h-10"
                                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" />
                                    </a>
                                    <div class="-mr-2 flex items-center md:hidden">
                                        <PopoverButton
                                            class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                            <span class="sr-only">Open main menu</span>
                                            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                                        </PopoverButton>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:ml-10 md:block md:space-x-8 md:pr-4">
                                <Link v-for="category in categories" :key="category.id" as="a"
                                    :href="route('category.index', category)"
                                    class="font-medium text-gray-500 hover:text-gray-900 capitalize">
                                {{ category.name }}
                                </Link>
                                <Cart class="" />
                            </div>
                        </nav>
                    </div>

                    <transition enter-active-class="duration-150 ease-out" enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in"
                        leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                        <PopoverPanel focus
                            class="absolute inset-x-0 top-0 z-10 origin-top-right transform p-2 transition md:hidden">
                            <div class="overflow-hidden rounded-lg bg-white shadow-md ring-1 ring-black ring-opacity-5">
                                <div class="flex items-center justify-between px-5 pt-4">
                                    <div>
                                        <img class="h-8 w-auto"
                                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="" />
                                    </div>
                                    <div class="-mr-2">
                                        <PopoverButton
                                            class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                            <span class="sr-only">Close main menu</span>
                                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                        </PopoverButton>
                                    </div>
                                </div>
                                <div class="space-y-1 px-2 pt-2 pb-3">
                                    <Link v-for="item in navigation" :key="item.name" :href="item.href"
                                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                                    {{
                                        item.name
                                    }}</Link>
                                </div>
                                <Link :href="route('login')"
                                    class="block w-full bg-gray-50 px-5 py-3 text-center font-medium text-indigo-600 hover:bg-gray-100">
                                Log in</Link>
                            </div>
                        </PopoverPanel>
                    </transition>
                </Popover>

                <main class="mx-auto mt-10 max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Data to enrich your</span>
                            <span class="block text-[#0CB26B] xl:inline">online business</span>
                        </h1>
                        <p
                            class="mt-3 text-base text-gray-500 sm:mx-auto sm:mt-5 sm:max-w-xl sm:text-lg md:mt-5 md:text-xl lg:mx-0">
                            Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat
                            commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#"
                                    class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 md:py-4 md:px-10 md:text-lg">Get
                                    started</a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#"
                                    class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-100 px-8 py-3 text-base font-medium text-indigo-700 hover:bg-indigo-200 md:py-4 md:px-10 md:text-lg">Live
                                    demo</a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:h-full lg:w-full"
                src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80"
                alt="" />
        </div>
    </div>
</template>
