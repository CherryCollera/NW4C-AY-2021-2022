<template>
    <div class="fixed bottom-10 border ml-5 mr-5 border-gray-300 z-50 grid grid-cols-6 gap-0 flex max-w-xs mx-auto overflow-hidden bg-white rounded-lg shadow-2xl" v-if="show && message">

        <div class="col-start-1 col-end-2 flex items-center justify-center w-12" :class="{ 'bg-green-500': style == 'success', 'bg-red-700': style == 'danger' }">
            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" v-if="style == 'success'">
                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
            </svg>

            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" v-if="style == 'danger'">
                <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"/>
            </svg>
        </div>
        
        <div class="col-start-2 col-end-6 px-4 py-2 -mx-3">
            <div class="mx-3">
                <span class="font-semibold" :class="{ 'text-green-500': style == 'success', 'text-red-700': style == 'danger' }">{{ style == 'success' ? 'Success' : 'Error' }}</span>
                <p class="text-sm text-gray-600">{{ message }}</p>
            </div>
        </div>
        <div class="col-start-7 mr-1 mt-1">
            <button
                type="button"
                class="bg-gray-300 flex p-2 rounded-md focus:outline-none transition"
                :class="{ 'hover:bg-green-500 focus:bg-green-600': style == 'success', 'hover:bg-red-700 focus:bg-red-800': style == 'danger' }"
                aria-label="Dismiss"
                @click.prevent="show = false">
                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                show: true,
            }
        },

        computed: {
            style() {
                return this.$page.props.jetstream.flash?.bannerStyle || 'success'
            },

            message() {
                return this.$page.props.jetstream.flash?.banner || ''
            },

            id() {
                return this.$page.props.jetstream.flash?.bannerId || null
            }
        },

        watch: {
            id(current, old) {
                if (current !== old) {
                this.show = true;
                }
            }
        }
    }
</script>
