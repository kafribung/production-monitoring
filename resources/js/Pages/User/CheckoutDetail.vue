<script setup>
// Inertia
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import NProgress from 'nprogress'

// Component
import Navbar from "@/Components/Navbar.vue";
import Banner from "@/Components/Banner.vue";
import Footer from "@/Components/Footer.vue";
import Currency from "@/Components/Currency.vue";

import { ref, reactive } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from "axios";

// Setter
const url_img = location.origin + '/storage/'

const props = defineProps({
    checkouts: Object
})

const obj = reactive({
    checkout_carts: null,
    open: false
})
// Function
function openModal(checkout_carts) {
    obj.checkout_carts = checkout_carts
    obj.open = !obj.open


}




// console.log(usePage().props.value.auth.user.email);
// Submit handler
function submit(checkout) {
    let item_details = []
    checkout.checkout_carts.forEach(function (item, index) {
        let data = {
            'id': item.cart.id,
            'name': item.cart.product.name,
            'price': item.cart.price,
            'quantity': item.cart.quantity,
            'color': item.cart.color.name,
            'size': item.cart.size.name,
        }

        item_details.push(data)
    })

    item_details = Object.assign({}, item_details)

    axios.post('https://app.sandbox.midtrans.com/snap/v1/transactions', {
        transaction_details: {
            order_id: checkout.order_number,
            gross_amount: checkout.total
        },
        credit_card: {
            secure: true
        },
        // "item_details": [item_details],
        // "customer_details": {
        //     "first_name": "Pembeli",
        //     "last_name": usePage().props.value.auth.user.name,
        //     "email": usePage().props.value.auth.user.email,
        //     "phone": "+628123456",
        //     "billing_address": {
        //         "first_name": "TEST",
        //         "last_name": "MIDTRANSER",
        //         "email": "noreply@example.com",
        //         "phone": "081 2233 44-55",
        //         "address": "Sudirman",
        //         "city": "Jakarta",
        //         "postal_code": "12190",
        //         "country_code": "IDN"
        //     },
        //     "shipping_address": {
        //         "first_name": "TEST",
        //         "last_name": "MIDTRANSER",
        //         "email": "noreply@example.com",
        //         "phone": "0812345678910",
        //         "address": "Sudirman",
        //         "city": "Jakarta",
        //         "postal_code": "12190",
        //         "country_code": "IDN"
        //     }
        // }
    }, {
        headers: {
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
            "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded',
            'Authorization': 'Basic U0ItTWlkLXNlcnZlci1nSmh3b284V3FOOWFCelJVbEM5LXdSbVg6',
        }
    })
        .then(response => {
            // Handle response
            console.log(response.data);
        })
        .catch(err => {
            // Handle errors
            console.log(err);
        });


    // window.snap.pay('16125dce-c440-426a-a835-7417b7c33ce4', {
    //     onSuccess: function (result) {
    //         /* You may add your own implementation here */
    //         alert("payment success!"); console.log(result);
    //     },
    //     onPending: function (result) {
    //         /* You may add your own implementation here */
    //         alert("wating your payment!"); console.log(result);
    //     },
    //     onError: function (result) {
    //         /* You may add your own implementation here */
    //         alert("payment failed!"); console.log(result);
    //     },
    //     onClose: function () {
    //         /* You may add your own implementation here */
    //         alert('you closed the popup without finishing the payment');
    //     }
    // })
}

// NProgress
NProgress.start();
NProgress.done()
</script>

<template>
    <!-- Head -->

    <Head title="Detail" />
    <!-- <Head :title="`Detail ${product.name}`" /> -->

    <!-- Navbar -->
    <Navbar />

    <!-- Modal -->
    <TransitionRoot as="template" :show="obj.open">

        <Dialog as="div" class="relative z-10" @close="obj.open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div>
                                <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                                    <h3 class="sr-only">Items in your cart</h3>
                                    <ul role="list" class="divide-y divide-gray-200">
                                        <li v-for="checkout_cart in obj.checkout_carts" :key="checkout_cart.id"
                                            class="flex py-6 px-4 sm:px-6">
                                            <!-- {{ checkout_cart.cart }} -->
                                            <div class="flex-shrink-0">
                                                <img :src="url_img + checkout_cart.cart.product.oldest_image.name"
                                                    :alt="checkout_cart.cart.product.oldest_image.name"
                                                    class="w-20 rounded-md" />
                                            </div>

                                            <div class="ml-6 flex flex-1 flex-col">
                                                <div class="flex">
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <Link
                                                                :href="route('detail.index', checkout_cart.cart.product.slug)"
                                                                class="font-medium text-gray-700 hover:text-gray-800">{{
                                                                    checkout_cart.cart.product.name
                                                                }}</Link>
                                                        </h4>
                                                        <div :style="{ backgroundColor: checkout_cart.cart.color.hexa }"
                                                            class="h-5 w-5 rounded-full mt-4">
                                                        </div>
                                                        <p class="mt-4 text-sm text-gray-500">{{
                                                            checkout_cart.cart.size.name }}</p>
                                                    </div>


                                                </div>

                                                <div class="flex flex-1 items-end justify-between pt-2">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        <Currency :price="checkout_cart.cart.price" />
                                                    </p>

                                                    <p class="ml-4 text-sm font-semibold text-gray-900">
                                                        {{ checkout_cart.cart.quantity }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6">
                                <button type="button"
                                    class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    @click="obj.open = false">Kembali</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>


    <!-- Product Overviews -->
    <div class="bg-white">
        <!-- Alert -->
        <div v-if="$page.props.flash.message">
            <Banner :message="$page.props.flash.message" />
        </div>

        <!-- Header Sections -->
        <div class="bg-gray-900 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Support center</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-300">Anim aute id magna aliqua ad ad non deserunt sunt.
                        Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="relative mx-auto max-w-7xl p-4 sm:p-8 lg:px-8">
            <div class="mt-2 flow-root">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                        Order Id
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Email
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Alamat
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Subtotal
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Ongkir
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Total
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Status
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <!-- {{ checkouts }} -->
                                <tr v-for="checkout in checkouts" :key="checkout.order_number">
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ checkout.order_number }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="text-gray-900">{{ checkout.created_by.email }}</div>
                                        <div class="text-gray-500">{{ checkout.created_by.name }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ checkout.address }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <Currency :price="checkout.subtotal" />
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <Currency :price="checkout.shipping" />
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <Currency :price="checkout.total" />
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 "
                                            :class="{ 'bg-green-100  text-green-800': checkout.status == 'success', 'bg-gray-100  text-gray-800': checkout.status == 'pending', 'bg-red-100  text-red-800': checkout.status == 'error' }">
                                            {{ checkout.status }}
                                        </span>
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <button type="button"
                                            class="rounded bg-white py-1 px-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                            @click="openModal(checkout.checkout_carts)">Orderan</button>

                                        <button type="button"
                                            class="rounded bg-white py-1 ml-2 px-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-indigo-300 hover:bg-indigo-50"
                                            @click="submit(checkout)">Bayar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <Footer />
</template>
