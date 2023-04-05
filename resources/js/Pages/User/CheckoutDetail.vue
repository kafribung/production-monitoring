<script setup>
// Inertia
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import NProgress from 'nprogress'

// Component
import Navbar from "@/Components/Navbar.vue";
import Banner from "@/Components/Banner.vue";
import Footer from "@/Components/Footer.vue";
import Currency from "@/Components/Currency.vue";

import { reactive } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import CheckoutPending from "@/Components/CheckoutPending.vue";

// Setter
const url_img = location.origin + '/storage/'

const props = defineProps({
    checkouts: Object
})

const obj = reactive({
    checkout_carts: null,
    open: false,
    transaction: {},
    open_checkout_pending: false
})
// Function
function openModal(checkout_carts) {
    obj.checkout_carts = checkout_carts
    obj.open = !obj.open
}

// Submit handler
async function submit(checkout) {
    // Add item details count
    let item_details = []
    checkout.checkout_carts.forEach(function (item) {
        let item_detail = {
            'id': item.cart.id,
            'name': item.cart.product.name,
            'price': item.cart.price,
            'quantity': item.cart.quantity,
            'color': item.cart.color.name,
            'size': item.cart.size.name,
            'subtotal': checkout.subtotal,
            'shipping': checkout.shipping,
        }
        item_details.push(item_detail)
    })

    // Add shipping count
    const shipping = {
        "id": Math.random(),
        "price": checkout.shipping,
        "quantity": 1,
        "name": "Shipping"
    }

    item_details.push(shipping)

    const headers = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        }
    }
    const data = {
        "auth": {
            "id": usePage().props.value.auth.user.id
        },
        "transaction_details": {
            "order_id": checkout.order_number,
            "gross_amount": checkout.total
        },
        "credit_card": {
            "secure": true
        },
        "item_details": item_details,
        "customer_details": {
            "first_name": "Costumer",
            "last_name": usePage().props.value.auth.user.name,
            "email": usePage().props.value.auth.user.email,
            "phone": checkout.phone,
            "billing_address": {
                "first_name": "Costumer",
                "last_name": usePage().props.value.auth.user.name,
                "email": usePage().props.value.auth.user.email,
                "phone": checkout.phone,
                "address": checkout.address,
                "province_id": checkout.province_id,
                "district_id": checkout.district_id,
            },
            "shipping_address": {
                "first_name": "Costumer",
                "last_name": usePage().props.value.auth.user.name,
                "email": usePage().props.value.auth.user.email,
                "phone": checkout.phone,
                "address": checkout.address,
                "province_id": checkout.province_id,
                "district_id": checkout.district_id,
            }
        }
    }

    try {
        const response = await axios.post('http://127.0.0.1:8000/api/midtrans', data, headers)

        if (response.data.data.token) {
            window.snap.pay(response.data.data.token, {
                onSuccess: function (result) {
                    /* You may add your own implementation here */
                    alert("payment success!"); console.log(result);
                },
                onPending: function (result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!"); console.log(result);
                },
                onError: function (result) {
                    /* You may add your own implementation here */
                    alert("payment failed!"); console.log(result);
                },
                onClose: function () {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        }

        // Set data
        obj.transaction = response.data.data

        // Reload page if not success or pending
        if (obj.transaction.transaction_status && (obj.transaction.transaction_status != 'pending' && obj.transaction.transaction_status != 'success'))
            return location.reload()

        // Trigger modal checkout pending
        obj.open_checkout_pending = !obj.open_checkout_pending

        // console.log(response);

    } catch (error) {
        // console.log(error)
    }
}

function destroy(checkout_id) {
    Inertia.delete(`/checkout/${checkout_id}`, {
        onBefore: () => confirm('Apakah anda setuju menghapus orderan?'),
    })
}

// NProgress
NProgress.start();
NProgress.done()
</script>

<template>
    <!-- Head -->

    <Head title="Detail" />

    <!-- Navbar -->
    <Navbar />

    <!-- Modal Checkout Pending -->
    <CheckoutPending v-if="obj.transaction.transaction_status == 'pending'" :open="obj.open_checkout_pending"
        :transaction="obj.transaction" />
    <!-- End Modal Checkout Pending -->

    <!-- Modal Item Cart-->
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
    <!-- End Modal Item Cart-->

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
                                            :class="{ 'bg-green-100  text-green-800': checkout.status == 'success', 'bg-gray-100  text-gray-800': checkout.status == 'pending', 'bg-red-100  text-red-800': checkout.status == 'error' || checkout.status == 'deny' || checkout.status == 'cancel' || checkout.status == 'expire' }">
                                            {{ checkout.status }}
                                        </span>
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <button type="button"
                                            class="rounded bg-white py-1 px-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                            @click="openModal(checkout.checkout_carts)">Orderan</button>

                                        <div class="inline" v-if="checkout.status != 'success'">
                                            <button type="button"
                                                class="rounded bg-white py-1 ml-2 px-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-indigo-300 hover:bg-indigo-50"
                                                @click="submit(checkout)">Bayar</button>

                                            <button type="button"
                                                class="rounded bg-white py-1 ml-2 px-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-50"
                                                @click="destroy(checkout.id)">Hapus</button>
                                        </div>

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
