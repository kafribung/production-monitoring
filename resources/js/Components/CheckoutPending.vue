
<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { CreditCardIcon } from '@heroicons/vue/24/outline'

// Component
import Currency from "@/Components/Currency.vue";

defineProps({
    open: false,
    transaction: Object
})

</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
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
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <CreditCardIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">
                                        Menunggu Pelunasan
                                    </DialogTitle>
                                    <div class="mt-3">
                                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                                            <li class="py-3">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <span aria-hidden="true"></span>
                                                        Order Id
                                                    </a>
                                                </h3>
                                                <p class="mt-1 line-clamp-2 text-sm text-gray-600">
                                                    {{ transaction.order_id }}
                                                </p>
                                            </li>
                                            <li class="py-3">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <span aria-hidden="true"></span>
                                                        Total Bayar
                                                    </a>
                                                </h3>
                                                <p class="mt-1 line-clamp-2 text-sm text-gray-600">
                                                    <Currency :price="Number(transaction.gross_amount.slice(0, -3))" />
                                                </p>
                                            </li>
                                            <li class="py-3">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <span aria-hidden="true"></span>
                                                        Nomor Akun Virtual
                                                    </a>
                                                </h3>
                                                <p class="mt-1 line-clamp-2 text-sm text-gray-600">
                                                    {{ transaction['va_numbers'][0].bank }}
                                                    ({{ transaction['va_numbers'][0].va_number }})
                                                </p>
                                            </li>
                                            <li class="py-3">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <span aria-hidden="true"></span>
                                                        Tanggal Transaksi
                                                    </a>
                                                </h3>
                                                <p class="mt-1 line-clamp-2 text-sm text-gray-600">
                                                    {{ transaction.transaction_time }}
                                                </p>
                                            </li>
                                            <li class="py-3">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="#" class="hover:underline focus:outline-none">
                                                        <span aria-hidden="true"></span>
                                                        Tanggal Expired
                                                    </a>
                                                </h3>
                                                <p class="mt-1 line-clamp-2 text-sm text-gray-600">
                                                    {{ transaction.expiry_time }}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 justify-end sm:ml-10 sm:mt-4 sm:flex sm:pl-4">
                                <button type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto"
                                    @click="open = false" ref="cancelButtonRef">Keluar</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>


