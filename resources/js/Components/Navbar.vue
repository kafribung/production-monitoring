<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { computed } from 'vue'

// Component
import Cart from "@/Components/Cart.vue";

const categories = computed(() => usePage().props.value.categories)

</script>

<template>
    <Disclosure as="nav" class="bg-white shadow" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <DisclosureButton
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <Link :href="route('home')">
                        <img class="block h-8 w-auto lg:hidden"
                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
                        <img class="hidden h-8 w-auto lg:block"
                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
                        </Link>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <Link v-for="category in categories" :key="category.id" :href="route('category.index', category)"
                            :class="{ 'border-b-2 border-indigo-500': $page.url === '/category/' + category.name }"
                            class="inline-flex items-center  px-1 pt-1 text-sm font-medium text-gray-900 capitalize">
                        {{ category.name }}
                        </Link>
                    </div>
                </div>
                <!-- Cart -->
                <Cart />
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 pt-2 pb-4">
                <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
                <Link v-for="category in categories" :key="category.id" :href="route('category.index', category)"
                    :class="{ 'border-b-2 border-indigo-500': $page.url === '/category/' + category.name }"
                    class="block border-l-4 border-indigo-500 bg-indigo-50 py-2 pl-3 pr-4 text-base font-medium text-indigo-700 capitalize">
                {{ category.name }}
                </Link>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
