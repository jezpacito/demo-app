<template>
    <form>
        <div
            class="gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800"
        >
            <div class="pt-3 sm:pt-5">
                <h2 class="text-xl font-semibold text-black dark:text-white">
                    URL Shortener
                </h2>

                <div class="mt-4 text-sm/relaxed">
                    <div class="p-6 mb-2">
                        <form class="w-full max-w-sm">
                            <div class="flex flex-wrap mb-6 -mx-3">
                                <div class="w-full px-3">
                                    <input
                                        class="block w-full px-4 py-3 mb-3 text-sm leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="grid-password"
                                        type="text"
                                        placeholder="Email (Optional)"
                                    />
                                    <p class="text-xs italic text-gray-600">
                                        error message here
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-center py-2 border-b border-red-500"
                            >
                                <input
                                    class="w-full px-2 py-1 mr-3 leading-tight text-gray-700 bg-transparent border-none appearance-none focus:outline-none"
                                    type="text"
                                    placeholder="URL"
                                    aria-label="URL Shortener "
                                />
                            </div>
                            <button
                                class="px-2 py-1 mt-3 text-sm text-white bg-red-500 border-4 border-red-500 rounded hover:bg-red-700 hover:border-red-700"
                                type="button"
                            >
                                Shorten
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
