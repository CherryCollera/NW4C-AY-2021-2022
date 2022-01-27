<template>
  <div style="background-color: #f1fae9" class="pb-10">
    <jet-authentication-card>
      <template #logo>
        <jet-authentication-card-logo />
      </template>

      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div>
          <jet-label for="fname" value="First Name" />
          <jet-input
            id="fname"
            type="text"
            class="mt-1 block w-full"
            v-model="form.fname"
            required
            autofocus
            autocomplete="fname"
          />
        </div>

        <div>
          <jet-label for="mname" value="Middle Name" />
          <jet-input
            id="mname"
            type="text"
            class="mt-1 block w-full"
            v-model="form.mname"
            required
            autofocus
            autocomplete="mname"
          />
        </div>

        <div>
          <jet-label for="lname" value="Last Name" />
          <jet-input
            id="lname"
            type="text"
            class="mt-1 block w-full"
            v-model="form.lname"
            required
            autofocus
            autocomplete="lname"
          />
        </div>

        <div class="mt-4">
          <jet-label for="email" value="Email" />
          <jet-input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
          />
        </div>

        <div class="mt-4">
          <jet-label for="birthdate" value="Birthdate" />
          <jet-input
            id="birthdate"
            type="date"
            class="block mt-1 w-full"
            v-model="form.birthdate"
            required
          />
        </div>

        <div class="mt-4">
          <jet-label for="city" value="City" />
          <select
            class="
              mt-1
              block
              w-full
              border-gray-300
              focus:border-green-300
              focus:ring
              focus:ring-green-200
              focus:ring-opacity-50
              rounded-md
              shadow-sm
            "
            id="city"
            ref="city"
            v-model="form.city"
            required
          >
            <option disabled value="" selected>Select City</option>
            <option
              v-for="(option, index) in cityLists"
              v-bind:value="option.value"
              :key="index"
            >
              {{ option.text }}
            </option>
          </select>
        </div>

        <div class="mt-4">
          <jet-label for="contact_number" value="Contact Number" />
          <jet-input
            id="contact_number"
            class="block mt-1 w-full"
            v-model="form.contact_number"
            type="tel"
            pattern="^(09|\+639)\d{9}$"
            placeholder="09xxxxxxxxx"
            required
          />
        </div>

        <div class="mt-4">
          <jet-label for="password" value="Password" />
          <jet-input
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="new-password"
          />
        </div>

        <div class="mt-4">
          <jet-label for="password_confirmation" value="Confirm Password" />
          <jet-input
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
          />
        </div>

        <div
          class="mt-4"
          v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
        >
          <jet-label for="terms">
            <div class="flex items-center">
              <jet-checkbox
                name="terms"
                id="terms"
                v-model:checked="form.terms"
              />

              <div class="ml-2">
                I agree to the
                <a
                  target="_blank"
                  :href="route('terms.show')"
                  class="underline text-sm text-gray-600 hover:text-gray-900"
                  >Terms of Service</a
                >
                and
                <a
                  target="_blank"
                  :href="route('policy.show')"
                  class="underline text-sm text-gray-600 hover:text-gray-900"
                  >Privacy Policy</a
                >
              </div>
            </div>
          </jet-label>
        </div>

        <div class="flex items-center justify-end mt-4">
          <inertia-link
            :href="route('login')"
            class="underline text-sm text-gray-600 hover:text-gray-900"
          >
            Already registered?
          </inertia-link>

          <jet-button
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Register
          </jet-button>
        </div>
      </form>
    </jet-authentication-card>
  </div>
</template>

<script>
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";
import Select from "@/Components/Select";

export default {
  components: {
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
    JetValidationErrors,
    Select,
  },

  data() {
    return {
      form: this.$inertia.form({
        mname: "",
        lname: "",
        fname: "",
        name: "",
        email: "",
        birthdate: "",
        city: "",
        contact_number: "",
        password: "",
        password_confirmation: "",
        terms: false,
      }),
      cityLists: [
        { text: "Balanga", value: "balanga" },
        { text: "Pilar", value: "pilar" },
        { text: "Abucay", value: "abucay" },
        { text: "Bagac", value: "bagac" },
        { text: "Morong", value: "morong" },
        { text: "Dinalupihan", value: "dinalupihan" },
        { text: "Orani", value: "orani" },
        { text: "Hermosa", value: "hermosa" },
        { text: "Mariveles", value: "mariveles" },
        { text: "Limay", value: "limay" },
        { text: "Orion", value: "orion" },
        { text: "Samal", value: "samal" },
      ],
    };
  },

  methods: {
    submit() {
      this.form.name =
        this.form.fname +
        " " +
        this.form.mname.charAt(0) +
        ". " +
        this.form.lname;

      this.form.post(this.route("register"), {
        onFinish: () => this.form.reset("password", "password_confirmation"),
      });
    },
  },
};
</script>
