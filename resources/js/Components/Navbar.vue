<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { CheckIcon, ClockIcon } from '@heroicons/vue/20/solid'

const products = [
    {
        id: 1,
        name: 'Nomad Tumbler',
        href: '#',
        price: '$35.00',
        color: 'White',
        inStock: true,
        imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-product-03.jpg',
        imageAlt: 'Insulated bottle with white base and black snap lid.',
    },
    {
        id: 2,
        name: 'Basic Tee',
        href: '#',
        price: '$32.00',
        color: 'Sienna',
        inStock: true,
        size: 'Large',
        imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-product-01.jpg',
        imageAlt: "Front of men's Basic Tee in sienna.",
    },
    // More products...
]

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
                        <img class="block h-8 w-auto lg:hidden"
                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
                        <img class="hidden h-8 w-auto lg:block"
                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900">Dashboard</a>
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">Team</a>
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">Projects</a>
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">Calendar</a>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Test dropdown -->
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton v-if="$page.props.auth.user" type="button"
                                class="rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="h-6 w-6" aria-hidden="true" />
                            </MenuButton>
                        </div>

                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-96 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <!-- <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                    <a href="#"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Account
                                        settings</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                    <a href="#"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Support</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                    <a href="#"
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">License</a>
                                    </MenuItem>
                                    <form method="POST" action="#">
                                        <MenuItem v-slot="{ active }">
                                        <button type="submit"
                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block w-full px-4 py-2 text-left text-sm']">Sign
                                            out</button>
                                        </MenuItem>
                                    </form>
                                </div> -->


                                <form class="p-4">
                                    <section aria-labelledby="cart-heading">
                                        <ul role="list"
                                            class="divide-y divide-gray-200 border-t border-b border-gray-200">
                                            <li v-for="product in products" :key="product.id" class="flex py-6">
                                                <div class="flex-shrink-0">
                                                    <img :src="product.imageSrc" :alt="product.imageAlt"
                                                        class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32" />
                                                </div>

                                                <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                                    <div>
                                                        <div class="flex justify-between">
                                                            <h4 class="text-sm">
                                                                <a :href="product.href"
                                                                    class="font-medium text-gray-700 hover:text-gray-800">{{
                                                                        product.name
                                                                    }}</a>
                                                            </h4>
                                                            <p class="ml-4 text-sm font-medium text-gray-900">{{
                                                                product.price
                                                            }}</p>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500">{{ product.color }}
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">{{ product.size }}</p>
                                                    </div>

                                                    <div class="mt-4 flex flex-1 items-end justify-between">
                                                        <p class="flex items-center space-x-2 text-sm text-gray-700">
                                                            <CheckIcon v-if="product.inStock"
                                                                class="h-5 w-5 flex-shrink-0 text-green-500"
                                                                aria-hidden="true" />
                                                            <ClockIcon v-else
                                                                class="h-5 w-5 flex-shrink-0 text-gray-300"
                                                                aria-hidden="true" />
                                                            <span>{{
                                                                product.inStock ? 'In stock' : `Will ship in
                                                                                                                            ${product.leadTime}`
                                                            }}</span>
                                                        </p>
                                                        <div class="ml-4">
                                                            <button type="button"
                                                                class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                                <span>Remove</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </section>

                                    <!-- Order summary -->
                                    <section aria-labelledby="summary-heading" class="mt-10">
                                        <h2 id="summary-heading" class="sr-only">Order summary</h2>

                                        <div>
                                            <dl class="space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <dt class="text-base font-medium text-gray-900">Subtotal</dt>
                                                    <dd class="ml-4 text-base font-medium text-gray-900">$96.00</dd>
                                                </div>
                                            </dl>
                                            <p class="mt-1 text-sm text-gray-500">Shipping and taxes will be calculated
                                                at checkout.</p>
                                        </div>

                                        <div class="mt-10">
                                            <button type="submit"
                                                class="w-full rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Checkout</button>
                                        </div>
                                    </section>

                                </form>
                            </MenuItems>
                        </transition>
                    </Menu>
                    <!-- Profile dropdown -->
                    <Menu as="div" class="relative ml-3">
                        <div>
                            <MenuButton v-if="$page.props.auth.user"
                                class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="" />
                            </MenuButton>
                            <div v-else class="flex items-center md:ml-12">
                                <Link :href="route('login')"
                                    class="text-base font-medium text-gray-500 hover:text-gray-900">Login</Link>
                                <Link :href="route('register')"
                                    class="ml-8 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                                Daftar</Link>
                            </div>
                        </div>
                        <transition v-if="$page.props.auth.user" enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <MenuItem v-slot="{ active }">
                                <a href="#"
                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Your
                                    Profile</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <a href="#"
                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Settings</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <a href="#"
                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Sign
                                    out</a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 pt-2 pb-4">
                <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
                <DisclosureButton as="a" href="#"
                    class="block border-l-4 border-indigo-500 bg-indigo-50 py-2 pl-3 pr-4 text-base font-medium text-indigo-700">
                    Dashboard</DisclosureButton>
                <DisclosureButton as="a" href="#"
                    class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">
                    Team</DisclosureButton>
                <DisclosureButton as="a" href="#"
                    class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">
                    Projects</DisclosureButton>
                <DisclosureButton as="a" href="#"
                    class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">
                    Calendar</DisclosureButton>
            </div>
        </DisclosurePanel>


    </Disclosure>
</template>
