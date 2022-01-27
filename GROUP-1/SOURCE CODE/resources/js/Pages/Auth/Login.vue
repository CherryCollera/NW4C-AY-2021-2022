<template>
    <div class="flex w-screen h-screen mx-auto overflow-hidden rounded-lg shadow-lg" style="background-color:#F1FAE9;">
        <div class="hidden bg-cover lg:block lg:w-1/2" style="background-image:url('/img/login-bg.jpg')"></div>
        
        <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
            <jet-authentication-card>
                <template #logo>
                    <jet-authentication-card-logo />
                </template>

                <jet-validation-errors class="mb-4" />

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
                    </div>

                    <div class="mt-4">
                        <jet-label for="password" value="Password" />
                        <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <jet-checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <inertia-link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                            Forgot your password?
                        </inertia-link>

                        <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </jet-button>

                    </div>

                    <div class="flex items-center justify-between mt-10 mb-6">
                        <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>

                        <inertia-link :href="route('register')" class="text-xs text-gray-600 uppercase hover:underline">or sign up</inertia-link>
                        
                        <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
                    </div>
                </form>
            </jet-authentication-card>
        </div>
    </div>

</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
