<template>
    <confirmation-modal :show="show">
            <template #title>
                <h2>Reject Offer</h2>
            </template>

            <template #content>
                <p>Are you sure you want to reject this offer? You can't undo this. The offerror will be notified.</p>
            </template>

            <template #footer>
                <secondary-button @click="close">
                    Cancel
                </secondary-button>

                <danger-button class="ml-2" @click="removeFromCart" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </danger-button>
            </template>
        </confirmation-modal>
</template>

<script>

    import ConfirmationModal from '@/Jetstream/ConfirmationModal'
    import SecondaryButton from '@/Jetstream/SecondaryButton'
    import DangerButton from '@/Jetstream/DangerButton'

    export default {

        props: ['show', 'close', 'offerID'],
        
        components: {
            ConfirmationModal,
            SecondaryButton,
            DangerButton,
        },

        data(){
            return{
                form: this.$inertia.form({
                    offerID: this.offerID,
                })
            }
        },

        methods:{
            removeFromCart(){
                this.form.put(route('rejectOffer', this.offerID), {
                preserveScroll: true,
                onSuccess: () => this.close(),
                onError: () => console.log('Cant reject offer'),
                onFinish: () => this.form.reset(),
            })
            },
        },
        
    }
</script>