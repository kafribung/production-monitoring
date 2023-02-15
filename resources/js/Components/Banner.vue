<script setup>
import { XMarkIcon } from '@heroicons/vue/20/solid'
import { reactive, computed } from 'vue';

// Props
const props = defineProps({
    message: String,
})

// Data
const test = reactive({
    show: true,
})

const classes = computed(() => test.show
    ? "flex pointer-events-auto items-center justify-between gap-x-6 bg-gray-900 py-2.5 px-6 sm:rounded-xl sm:py-3 sm:pr-3.5 sm:pl-4"
    : "hidden pointer-events-auto items-center justify-between gap-x-6 bg-gray-900 py-2.5 px-6 sm:rounded-xl sm:py-3 sm:pr-3.5 sm:pl-4"
)

function hiddenHandler() {
    test.show = false
}

</script>

<template>
    <!--
      Make sure you add some bottom padding to pages that include a sticky banner like this to prevent
      your content from being obscured when the user scrolls to the bottom of the page.
    -->
    <div class="flex pointer-events-none fixed inset-x-0 bottom-0 sm:flex sm:justify-center sm:px-6 sm:pb-5 lg:px-8">
        <div :class="classes">
            <p class="text-sm leading-6 text-white">
                <a href="#"><strong class="font-semibold">Success</strong><svg viewBox="0 0 2 2"
                        class="mx-2 inline h-0.5 w-0.5 fill-current" aria-hidden="true">
                        <circle cx="1" cy="1" r="1" />
                    </svg>{{ message }}</a>
            </p>
            <button @click="hiddenHandler" class="-m-1.5 flex-none p-1.5">
                <span class="sr-only">Dismiss</span>
                <XMarkIcon class="h-5 w-5 text-white" aria-hidden="true" />
            </button>
        </div>
    </div>
</template>
