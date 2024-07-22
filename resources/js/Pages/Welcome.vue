<script setup>
import { Head, Link } from "@inertiajs/vue3";
import axios from "axios";
import { Form, Field, ErrorMessage } from "vee-validate";
import { ref } from "vue";
import * as yup from "yup";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const schema = yup.object().shape({
    email: yup.string().email().optional(),
    url: yup
        .string()
        .required()
        .test("is-url-valid", "URL is not valid", (value) => isValidUrl(value)),
});

const isValidUrl = (url) => {
    try {
        new URL(url);
    } catch (e) {
        return false;
    }
    return true;
};
const url = ref("");
const shortenedUrl = ref("");
const hasEmail = ref("");
const onSubmit = async (values, { resetForm }) => {
    try {
        const response = await axios.post("/api/shorten", values);
        const res = response.data.data;
        url.value = res.shortened_url;
        shortenedUrl.value = response.data.data.shortened_url
            .replace("http://", "")
            .replace("api/", "");

        if (res.email) {
            hasEmail.value = res.email;
        } else {
            hasEmail.value = "";
        }

        resetForm();
        console.log(res.shortened_url); // Handle response data as needed
    } catch (error) {
        console.error("Error:", error.response.data);
        alert(error.response.data.message);
    }
};
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid items-center grid-cols-2 gap-2 py-10 lg:grid-cols-3"
                >
                    <div class="flex lg:justify-center lg:col-start-2"></div>
                    <nav v-if="canLogin" class="flex justify-end flex-1 -mx-3">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <div
                        class="gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800"
                    >
                        <div
                            v-if="url"
                            class="px-4 py-3 text-blue-700 bg-blue-100 border-t border-b border-blue-500"
                            role="alert"
                        >
                            <p class="font-bold">Success!</p>
                            <p class="text-sm" v-if="!hasEmail">
                                <a :href="url">
                                    <i>
                                        Your shortened link is:
                                        <u>{{ shortenedUrl }} </u></i
                                    >
                                </a>
                            </p>
                            <p class="text-sm" v-else>
                                <a :href="url">
                                    <i>
                                        Your shortened link has been sent to
                                        your email at
                                        <u>{{ hasEmail }} </u></i
                                    >
                                </a>
                            </p>
                        </div>
                        <div class="pt-3 sm:pt-5">
                            <h2
                                class="text-xl font-semibold text-black dark:text-white"
                            >
                                URL Shortener
                            </h2>

                            <div class="mt-4 text-sm/relaxed">
                                <div class="p-6 mb-2">
                                    <Form
                                        @submit="onSubmit"
                                        :validation-schema="schema"
                                    >
                                        <!-- Form fields -->
                                        <div class="flex flex-wrap mb-6 -mx-3">
                                            <div class="w-full px-3">
                                                <Field
                                                    class="block w-full px-4 py-3 mb-3 text-sm leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                                    id="grid-password"
                                                    type="text"
                                                    placeholder="Email (Optional)"
                                                    name="email"
                                                />

                                                <ErrorMessage
                                                    class="text-xs italic text-white-50"
                                                    name="email"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center py-2 border-b border-red-500"
                                        >
                                            <Field
                                                class="w-full px-2 py-1 mr-3 leading-tight bg-transparent border-none appearance-none text-white-50 focus:outline-none"
                                                type="text"
                                                name="url"
                                                placeholder="URL"
                                                aria-label="URL Shortener"
                                            />
                                        </div>
                                        <div>
                                            <ErrorMessage
                                                class="mt-5 text-xs italic text-white-50"
                                                name="url"
                                            />
                                        </div>
                                        <button
                                            class="px-2 py-1 mt-3 text-sm text-white bg-red-500 border-4 border-red-500 rounded hover:bg-red-700 hover:border-red-700"
                                            type="submit"
                                        >
                                            Shorten
                                        </button>
                                    </Form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <footer
                    class="py-16 text-sm text-center text-black dark:text-white/70"
                >
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
