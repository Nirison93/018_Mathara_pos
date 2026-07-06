<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

useI18n();
</script>

<template>
    <Head :title="$t('dashboard.admin_title')" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-6">

            <!-- Dashboard Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">{{ $t('dashboard.admin_title') }}</h1>
                <p class="text-gray-400">{{ $t('dashboard.subtitle') }}</p>
            </div>

            <!-- SECTION 1: Inventory Management -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-white mb-4 pb-2 border-b border-blue-600">
                    📦 {{ $t('dashboard.inventory_management') }}
                </h3>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                    <Link :href="route('products.index')"
                        class="group bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">📦</div>
                        <div class="font-semibold text-lg">{{ $t('products.title') }}</div>
                        <div class="text-sm text-blue-200 group-hover:text-blue-100">{{ $t('products.manage') }}</div>
                    </Link>

                    <Link :href="route('brands.index')"
                        class="group bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">🏷️</div>
                        <div class="font-semibold text-lg">{{ $t('brands.title') }}</div>
                        <div class="text-sm text-purple-200 group-hover:text-purple-100">{{ $t('brands.manage') }}</div>
                    </Link>

                    <Link :href="route('categories.index')"
                        class="group bg-gradient-to-br from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">📂</div>
                        <div class="font-semibold text-lg">{{ $t('categories.title') }}</div>
                        <div class="text-sm text-pink-200 group-hover:text-pink-100">{{ $t('categories.manage') }}</div>
                    </Link>

                    <Link :href="route('types.index')"
                        class="group bg-gradient-to-br from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">🔹</div>
                        <div class="font-semibold text-lg">{{ $t('types.title') }}</div>
                        <div class="text-sm text-indigo-200 group-hover:text-indigo-100">{{ $t('types.manage') }}</div>
                    </Link>

                    <Link :href="route('measurement-units.index')"
                        class="group bg-gradient-to-br from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">📏</div>
                        <div class="font-semibold text-lg">{{ $t('units.title') }}</div>
                        <div class="text-sm text-cyan-200 group-hover:text-cyan-100">{{ $t('units.manage') }}</div>
                    </Link>
                </div>
            </div>

            <!-- SECTION 2: Purchase & Stock Management -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-white mb-4 pb-2 border-b border-green-600">
                    🛒 {{ $t('dashboard.purchasing_stock') }}
                </h3>
                <div class="grid gap-4 md:grid-cols-3">
                    <Link :href="route('purchase-order-requests.index')"
                        class="group bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">📋</div>
                        <div class="font-semibold text-lg">{{ $t('purchase_orders.title') }}</div>
                        <div class="text-sm text-green-200 group-hover:text-green-100">{{ $t('purchase_orders.manage') }}</div>
                    </Link>

                    <Link :href="route('goods-received-notes.index')"
                        class="group bg-gradient-to-br from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">📦</div>
                        <div class="font-semibold text-lg">{{ $t('grn.goods_received') }}</div>
                        <div class="text-sm text-emerald-200 group-hover:text-emerald-100">{{ $t('grn.track_received') }}</div>
                    </Link>

                    <Link :href="route('suppliers.index')"
                        class="group bg-gradient-to-br from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">🏢</div>
                        <div class="font-semibold text-lg">{{ $t('suppliers.title') }}</div>
                        <div class="text-sm text-teal-200 group-hover:text-teal-100">{{ $t('suppliers.manage') }}</div>
                    </Link>
                </div>
            </div>

            <!-- SECTION 3: Sales Management -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-white mb-4 pb-2 border-b border-orange-600">
                    💰 {{ $t('dashboard.sales_management') }}
                </h3>
                <div class="grid gap-4 md:grid-cols-3">
                    <Link :href="route('customers.index')"
                        class="group bg-gradient-to-br from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">👥</div>
                        <div class="font-semibold text-lg">{{ $t('customers.title') }}</div>
                        <div class="text-sm text-orange-200 group-hover:text-orange-100">{{ $t('customers.manage') }}</div>
                    </Link>

                    <Link :href="route('discounts.index')"
                        class="group bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">🏷️</div>
                        <div class="font-semibold text-lg">{{ $t('discounts.title') }}</div>
                        <div class="text-sm text-red-200 group-hover:text-red-100">{{ $t('discounts.manage') }}</div>
                    </Link>

                    <Link :href="route('taxes.index')"
                        class="group bg-gradient-to-br from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">📊</div>
                        <div class="font-semibold text-lg">{{ $t('taxes.title') }}</div>
                        <div class="text-sm text-rose-200 group-hover:text-rose-100">{{ $t('taxes.manage') }}</div>
                    </Link>
                </div>
            </div>

            <!-- SECTION 4: System Management -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-white mb-4 pb-2 border-b border-slate-600">
                    ⚙️ {{ $t('dashboard.system_management') }}
                </h3>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                    <Link :href="route('users.index')"
                        class="group bg-gradient-to-br from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">👤</div>
                        <div class="font-semibold text-lg">{{ $t('users.title') }}</div>
                        <div class="text-sm text-slate-200 group-hover:text-slate-100">{{ $t('users.manage') }}</div>
                    </Link>
                </div>
            </div>

            <!-- SECTION 5: Settings -->
            <div>
                <h3 class="text-2xl font-bold text-white mb-4 pb-2 border-b border-slate-600">
                    🔧 {{ $t('dashboard.settings') }}
                </h3>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                    <Link :href="route('settings.company')"
                        class="group bg-gradient-to-br from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">🏢</div>
                        <div class="font-semibold text-lg">{{ $t('settings.company_info') }}</div>
                        <div class="text-sm text-slate-200 group-hover:text-slate-100">{{ $t('settings.company_info_desc') }}</div>
                    </Link>

                    <Link :href="route('settings.app')"
                        class="group bg-gradient-to-br from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 p-6 rounded-lg text-white transition transform hover:scale-105 shadow-lg">
                        <div class="text-3xl mb-2">⚙️</div>
                        <div class="font-semibold text-lg">{{ $t('settings.app_settings') }}</div>
                        <div class="text-sm text-slate-200 group-hover:text-slate-100">{{ $t('settings.app_settings_desc') }}</div>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
a { @apply transition-all duration-300 ease-in-out; }
</style>
