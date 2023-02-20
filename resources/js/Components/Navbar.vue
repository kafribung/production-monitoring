<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon, ShoppingBagIcon } from '@heroicons/vue/24/outline'
import { computed, reactive } from 'vue'
import Currency from "@/Components/Currency.vue";

// Data
const data = reactive({
    sum: 0,
    total: [],
})

// Setter
const url_img = location.origin + '/storage/'

// Function
function insertSubTotal(total) {
    data.total.push(total)
}
// Computed
const sub_total = computed(() => data.total.forEach(p => {
    data.sum += p;
}));

</script>

<template>
    {{ $page.props.carts.cart }}
    {{ sub_total }}
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
                                <!-- Cart -->
                                <div class="flex">
                                    <ShoppingBagIcon class="h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                        aria-hidden="true" />
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">{{
                                        $page.props.carts.cart.length }}</span>
                                    <span class="sr-only">items in cart, view bag</span>
                                </div>
                            </MenuButton>
                        </div>

                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-96 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <form class="p-4">
                                    <section aria-labelledby="cart-heading">
                                        <ul role="list" class="divide-y divide-gray-200 border-t border-b border-gray-200">
                                            <li v-for="(cart, index) in $page.props.carts.cart" :key="cart.id"
                                                class="flex py-6">
                                                <div class="flex-shrink-0">
                                                    <img :src="url_img + cart.product.oldest_image.name"
                                                        :alt="cart.product.oldest_image.name"
                                                        class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32" />
                                                </div>

                                                <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                                    <div>
                                                        <div class="flex justify-between">
                                                            <h4 class="text-sm">
                                                                <a :href="cart.href"
                                                                    class="font-medium text-gray-700 hover:text-gray-800">{{
                                                                        cart.product.name
                                                                    }}</a>
                                                            </h4>
                                                            <p class="ml-4 text-sm font-medium text-gray-900">
                                                                <Currency :price="cart.price" />
                                                            </p>
                                                            <div>{{ insertSubTotal(cart.price) }}</div>
                                                        </div>
                                                        <div :style="{ backgroundColor: cart.color.hexa }"
                                                            class="h-5 w-5 rounded-full mt-4">
                                                        </div>
                                                        <p class="mt-4 text-sm text-gray-500">{{ cart.size.name }}</p>
                                                    </div>

                                                    <div class="mt-4 flex items-end justify-end">
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
                                                    <dt class="text-base font-medium text-gray-900">Subtotal
                                                    </dt>
                                                    <dd class="ml-4 text-base font-medium text-gray-900">{{ sub_total }}
                                                    </dd>
                                                    <dd class="ml-4 text-base font-medium text-gray-900">{{ data.sum }}
                                                    </dd>

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
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
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
