<script setup>
// Inertia
import { Head, Link } from "@inertiajs/inertia-vue3";
import NProgress from 'nprogress'

// Component
import Navbar from "@/Components/Navbar.vue";
import Currency from "@/Components/Currency.vue";
import Banner from "@/Components/Banner.vue";

// Template
import { ref } from 'vue'
import { RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { CheckCircleIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { Inertia } from "@inertiajs/inertia";

// Setter
const url_img = location.origin + '/storage/'

// Props
const props = defineProps({
    provinces: Object,
    districts: Object,
    province_id: Number,
})
const province_id = ref(props.province_id);

// Function
function showDistrict(e) {
    Inertia.get(route('checkout.show_district', e.target.value), {
        // preserveScroll: (page) => Object.keys(page.props.errors).length,
        // preserveState: (page) => Object.keys(page.props.errors).length,
        preserveScroll: true,
        preserveState: true,
    })
}


const deliveryMethods = [
    { id: 1, title: 'Standard', turnaround: '4–10 business days', price: '$5.00' },
    { id: 2, title: 'Express', turnaround: '2–5 business days', price: '$16.00' },
]
const paymentMethods = [
    { id: 'credit-card', title: 'Credit card' },
    { id: 'paypal', title: 'PayPal' },
    { id: 'etransfer', title: 'eTransfer' },
]

const selectedDeliveryMethod = ref(deliveryMethods[0])

// NProgress
NProgress.start();
NProgress.done()
</script>

<template>
    {{ provinces }}
    <!-- Head -->

    <Head title="Checkout" />

    <!-- Navbar -->
    <Navbar />

    <div class="bg-gray-50">
        <!-- Alert -->
        <div v-if="$page.props.flash.message">
            <Banner :message="$page.props.flash.message" />
        </div>
        <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Checkout</h2>

            <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                <div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Contact information</h2>

                        <div class="mt-4">
                            <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input type="email" id="email-address" :value="$page.props.auth.user.email" disabled
                                    autocomplete="email"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" :value="$page.props.auth.user.name" disabled
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <div class="mt-1">
                                    <textarea name="address" id="address" autocomplete="street-address"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div>
                                <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                                <div class="mt-1">
                                    {{ }}

                                    <select id="province" v-model="province_id" v-on:change="showDistrict($event)"
                                        autocomplete="province-name"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option v-for="item in provinces" :key="item.province_id" :value="item.province_id">
                                            {{
                                                item.province
                                            }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="district" class="block text-sm font-medium text-gray-700">District</label>
                                <div class="mt-1">
                                    <select id="district" v-on:change="" autocomplete="province-name"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option v-for="item in districts" :key="item.city_id" :value="item.city_id">
                                            {{
                                                item.city_name
                                            }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal code</label>
                                <div class="mt-1">
                                    <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <div class="mt-1">
                                    <input type="text" name="phone" id="phone" autocomplete="tel"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <RadioGroup v-model="selectedDeliveryMethod">
                            <RadioGroupLabel class="text-lg font-medium text-gray-900">Delivery method</RadioGroupLabel>

                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <RadioGroupOption as="template" v-for="deliveryMethod in deliveryMethods"
                                    :key="deliveryMethod.id" :value="deliveryMethod" v-slot="{ checked, active }">
                                    <div
                                        :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'ring-2 ring-indigo-500' : '', 'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none']">
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">
                                                    {{ deliveryMethod.title }}</RadioGroupLabel>
                                                <RadioGroupDescription as="span"
                                                    class="mt-1 flex items-center text-sm text-gray-500">{{
                                                        deliveryMethod.turnaround }}</RadioGroupDescription>
                                                <RadioGroupDescription as="span"
                                                    class="mt-6 text-sm font-medium text-gray-900">{{ deliveryMethod.price
                                                    }}</RadioGroupDescription>
                                            </span>
                                        </span>
                                        <CheckCircleIcon v-if="checked" class="h-5 w-5 text-indigo-600"
                                            aria-hidden="true" />
                                        <span
                                            :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-lg']"
                                            aria-hidden="true" />
                                    </div>
                                </RadioGroupOption>
                            </div>
                        </RadioGroup>
                    </div>

                    <!-- Payment -->
                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Payment</h2>

                        <fieldset class="mt-4">
                            <legend class="sr-only">Payment type</legend>
                            <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                <div v-for="(paymentMethod, paymentMethodIdx) in paymentMethods" :key="paymentMethod.id"
                                    class="flex items-center">
                                    <input v-if="paymentMethodIdx === 0" :id="paymentMethod.id" name="payment-type"
                                        type="radio" checked=""
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    <input v-else :id="paymentMethod.id" name="payment-type" type="radio"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    <label :for="paymentMethod.id" class="ml-3 block text-sm font-medium text-gray-700">{{
                                        paymentMethod.title }}</label>
                                </div>
                            </div>
                        </fieldset>

                        <div class="mt-6 grid grid-cols-4 gap-y-6 gap-x-4">
                            <div class="col-span-4">
                                <label for="card-number" class="block text-sm font-medium text-gray-700">Card number</label>
                                <div class="mt-1">
                                    <input type="text" id="card-number" name="card-number" autocomplete="cc-number"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="col-span-4">
                                <label for="name-on-card" class="block text-sm font-medium text-gray-700">Name on
                                    card</label>
                                <div class="mt-1">
                                    <input type="text" id="name-on-card" name="name-on-card" autocomplete="cc-name"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="col-span-3">
                                <label for="expiration-date" class="block text-sm font-medium text-gray-700">Expiration date
                                    (MM/YY)</label>
                                <div class="mt-1">
                                    <input type="text" name="expiration-date" id="expiration-date" autocomplete="cc-exp"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div>
                                <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                                <div class="mt-1">
                                    <input type="text" name="cvc" id="cvc" autocomplete="csc"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order summary -->
                <div class="mt-10 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                    <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                        <h3 class="sr-only">Items in your cart</h3>
                        <ul role="list" class="divide-y divide-gray-200">
                            <li v-for="(cart, index) in $page.props.carts.cart" :key="index" class="flex py-6 px-4 sm:px-6">
                                <div class="flex-shrink-0">
                                    <img :src="url_img + cart.product.oldest_image.name"
                                        :alt="cart.product.oldest_image.name" class="w-20 rounded-md" />
                                </div>

                                <div class="ml-6 flex flex-1 flex-col">
                                    <div class="flex">
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm">
                                                <Link :href="route('detail.index', cart.product.slug)"
                                                    class="font-medium text-gray-700 hover:text-gray-800">{{
                                                        cart.product.name
                                                    }}</Link>
                                            </h4>
                                            <div :style="{ backgroundColor: cart.color.hexa }"
                                                class="h-5 w-5 rounded-full mt-4">
                                            </div>
                                            <p class="mt-4 text-sm text-gray-500">{{ cart.size.name }}</p>
                                        </div>

                                        <div class="ml-4 flow-root flex-shrink-0">
                                            <Link :href="route('cart.destroy', cart.id)" method="delete" as="button"
                                                type="button"
                                                class="-m-2.5 flex items-center justify-center bg-white p-2.5 text-gray-400 hover:text-gray-500">
                                            <span class="sr-only">Remove</span>
                                            <TrashIcon class="h-5 w-5" aria-hidden="true" />
                                            </Link>
                                        </div>
                                    </div>

                                    <div class="flex flex-1 items-end justify-between pt-2">
                                        <p class="text-sm font-medium text-gray-900">
                                            <Currency :price="cart.price" />
                                        </p>

                                        <p class="ml-4 text-sm font-semibold text-gray-900">
                                            {{ cart.qunatity }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <dl class="space-y-6 border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    <Currency :price="$page.props.carts.sub_total" />
                                </dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900">$5.00</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                <dt class="text-base font-medium">Total</dt>
                                <dd class="text-base font-medium text-gray-900">$75.52</dd>
                            </div>
                        </dl>

                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <button type="submit"
                                class="w-full rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Confirm
                                order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>


