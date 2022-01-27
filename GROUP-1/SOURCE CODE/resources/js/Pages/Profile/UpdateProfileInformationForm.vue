<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="getProfilePhoto(user)" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remove Photo
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input disabled id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Contact Number -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="contact_number" value="Contact Number" />
                <jet-input id="contact_number" type="text" class="mt-1 block w-full" v-model="form.contact_number" />
                <jet-input-error :message="form.errors.contact_number" class="mt-2" />
            </div>

            <!-- Current City -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="city" value="Current City" />
                <select class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                                id="city"
                                ref="city"
                                v-model="form.city"
                                required >

                        <option disabled value="" selected>Select City</option>
                        <option v-for="(option, index) in cityLists" v-bind:value="option.value" :key="index">
                            {{option.text}}
                        </option>
                    </select>
                <jet-input-error :message="form.errors.city" class="mt-2" />
            </div>

            <!-- Birthdate -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="birthdate" value="Birthdate" />
                <jet-input id="birthdate" type="date" class="mt-1 block w-full" v-model="form.birthdate" />
                <jet-input-error :message="form.errors.birthdate" class="mt-2" />
            </div>

            <!-- Bio -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="bio" value="Profile Bio" />
                <jet-input id="bio" type="text" class="mt-1 block w-full" v-model="form.bio" />
                <jet-input-error :message="form.errors.bio" class="mt-2" />
            </div>
        </template>
        
        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    photo: null,
                    contact_number: this.user.contact_number,
                    city: this.user.city,
                    birthdate: this.user.birthdate,
                    bio: this.user.bio,
                }),

                photoPreview: null,

                cityLists: [
                        { text: 'Balanga', value: 'balanga' },
                        { text: 'Pilar', value: 'pilar' },
                        { text: 'Abucay', value: 'abucay' },
                        { text: 'Bagac', value: 'bagac' },
                        { text: 'Morong', value: 'morong' },
                        { text: 'Dinalupihan', value: 'dinalupihan' },
                        { text: 'Orani', value: 'orani' },
                        { text: 'Hermosa', value: 'hermosa' },
                        { text: 'Mariveles', value: 'mariveles' },
                        { text: 'Limay', value: 'limay' },
                        { text: 'Orion', value: 'orion' },
                        { text: 'Samal', value: 'samal' },
                ],
            }
        },

        methods: {
            getProfilePhoto(user){
                if(user.profile_photo_path){
                    return '/storage/' + user.profile_photo_path
                }else{
                    return `https://ui-avatars.com/api/?name=${user.name}&color=059669&background=ECFDF5`
                }
            },

            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                    onSuccess: () => (this.clearPhotoFileInput()),
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.photoPreview = null;
                        this.clearPhotoFileInput();
                    },
                });
            },

            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {
                    this.$refs.photo.value = null;
                }
            },
        },
    }
</script>
