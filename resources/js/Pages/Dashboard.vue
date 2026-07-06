<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed, ref, onMounted } from "vue";
import { useI18n } from "vue-i18n";

useI18n();

const page = usePage();
const pageTitle = computed(() => {
  const appName = page.props.appSettings?.app_name || "POS";
  return appName;
});

const isTabAllowed = (tab, userRole) => {
  if (tab === "products") return [0, 1, 3].includes(userRole);
  if (tab === "shops") return [0, 1, 2, 3].includes(userRole);
  if (tab === "reports") return [0, 1, 2, 3].includes(userRole);
  if (tab === "settings") return ![2, 3].includes(userRole);
  return false;
};

const getDefaultTab = () => {
  const userRole = page.props.auth.user.role;
  if ([0, 1, 3].includes(userRole)) return "products";
  if ([4].includes(userRole)) return "stores";
  return "shops";
};

const activeTab = ref(getDefaultTab());

const setActiveTab = (tab) => {
  activeTab.value = tab;
  localStorage.setItem("activeTab", tab);
  sessionStorage.setItem("fromNavigation", "true");
};

onMounted(() => {
  const savedTab = localStorage.getItem("activeTab");
  const fromNavigation = sessionStorage.getItem("fromNavigation");
  const userRole = page.props.auth.user.role;

  if (savedTab && fromNavigation === "true" && isTabAllowed(savedTab, userRole)) {
    activeTab.value = savedTab;
    sessionStorage.removeItem("fromNavigation");
  } else {
    activeTab.value = getDefaultTab();
    localStorage.removeItem("activeTab");
  }
});
</script>

<template>
  <Head :title="pageTitle" />

  <AppLayout>
    <div class="min-h-screen overflow-y-auto bg-gray-50 pb-12">

      <!-- Tab Navigation -->
      <div class="px-4 sm:px-6 lg:px-8 mb-8 pt-6">
        <div class="relative z-10 flex flex-wrap justify-center gap-3 pb-3">
          <button
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            @click="setActiveTab('products')"
            :class="[
              activeTab === 'products'
                ? 'bg-gray-900 text-white rounded-lg shadow-sm border border-gray-900'
                : 'text-gray-600 rounded-lg border border-transparent hover:text-gray-900 hover:bg-white hover:border-gray-200',
              'px-4 py-2.5 font-medium text-sm whitespace-nowrap transition-all duration-200 flex items-center gap-2'
            ]"
          >
            <span>📦</span>
            <span class="hidden sm:inline">{{ $t('products.title') }}</span>
          </button>

          <button
            type="button"
            v-if="[0, 1, 2, 3].includes($page.props.auth.user.role)"
            @click="setActiveTab('shops')"
            :class="[
              activeTab === 'shops'
                ? 'bg-gray-900 text-white rounded-lg shadow-sm border border-gray-900'
                : 'text-gray-600 rounded-lg border border-transparent hover:text-gray-900 hover:bg-white hover:border-gray-200',
              'px-4 py-2.5 font-medium text-sm whitespace-nowrap transition-all duration-200 flex items-center gap-2'
            ]"
          >
            <span>💰</span>
            <span class="hidden sm:inline">{{ $t('dashboard.sales_management') }}</span>
          </button>

          <button
            v-if="[0, 1, 2, 3].includes($page.props.auth.user.role)"
            @click="setActiveTab('reports')"
            :class="[
              activeTab === 'reports'
                ? 'bg-gray-900 text-white rounded-lg shadow-sm border border-gray-900'
                : 'text-gray-600 rounded-lg border border-transparent hover:text-gray-900 hover:bg-white hover:border-gray-200',
              'px-4 py-2.5 font-medium text-sm whitespace-nowrap transition-all duration-200 flex items-center gap-2'
            ]"
          >
            <span>📊</span>
            <span class="hidden sm:inline">{{ $t('reports.title') }}</span>
          </button>

          <button
            v-if="![2, 3].includes($page.props.auth.user.role)"
            @click="setActiveTab('settings')"
            :class="[
              activeTab === 'settings'
                ? 'bg-gray-900 text-white rounded-lg shadow-sm border border-gray-900'
                : 'text-gray-600 rounded-lg border border-transparent hover:text-gray-900 hover:bg-white hover:border-gray-200',
              'px-4 py-2.5 font-medium text-sm whitespace-nowrap transition-all duration-200 flex items-center gap-2'
            ]"
          >
            <span>🔧</span>
            <span class="hidden sm:inline">{{ $t('dashboard.settings') }}</span>
          </button>
        </div>
      </div>

      <!-- Products Section -->
      <div
        v-if="activeTab === 'products' && [0, 1, 3].includes($page.props.auth.user.role)"
        class="px-4 sm:px-6 lg:px-8 mb-8"
      >
        <h3 class="text-lg font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
          <span class="text-2xl">📦</span> {{ $t('dashboard.inventory_management') }}
        </h3>
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
          <Link
            v-if="[0, 1 ,3].includes($page.props.auth.user.role)"
            :href="route('products.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📦</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('products.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('products.create_manage') }}</div>
          </Link>

          <Link
            v-if="[0, 1].includes($page.props.auth.user.role)"
            :href="route('brands.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">⭐</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('brands.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('brands.manage_product_brands') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('categories.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🏷️</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('categories.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('categories.organize') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('types.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🧩</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('types.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('types.manage_product_types') }}</div>
          </Link>

          <Link
            v-if="[0, 1].includes($page.props.auth.user.role)"
            :href="route('measurement-units.index')"
            class="hidden group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📏</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('units.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('units.manage') }}</div>
          </Link>

          <Link
            v-if="[0, 1 ,3].includes($page.props.auth.user.role)"
            :href="route('suppliers.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🚚</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('suppliers.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('suppliers.manage_info') }}</div>
          </Link>

          <Link
            v-if="[0, 1 ,3].includes($page.props.auth.user.role)"
            :href="route('good-receive-notes.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📦</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('grn.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('grn.view_create') }}</div>
          </Link>
        </div>
      </div>

      <!-- Shops / Sales Section -->
      <div
        v-if="activeTab === 'shops' && [0, 1, 2, 3].includes($page.props.auth.user.role)"
        class="px-4 sm:px-6 lg:px-8 mb-8"
      >
        <h3 class="text-lg font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
          <span class="text-2xl">💰</span> {{ $t('dashboard.sales_management') }}
        </h3>
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('customers.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">👥</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('customers.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('customers.manage') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('discounts.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🏷️</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('discounts.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('discounts.manage') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('taxes.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📊</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('taxes.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('taxes.manage') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 2].includes($page.props.auth.user.role)"
            :href="route('sales.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">💳</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('sales.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('sales.manage') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 2].includes($page.props.auth.user.role)"
            :href="route().has('sales.all') ? route('sales.all') : route('sales.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📜</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('sales.history') }}</div>
            <div class="text-sm text-gray-600">{{ $t('sales.view_all') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('quotations.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📄</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('quotations.title') }}</div>
            <div class="text-sm text-gray-600">{{ $t('quotations.manage') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('quotation.edit')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">✏️</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('quotations.edit') }}</div>
            <div class="text-sm text-gray-600">{{ $t('quotations.update') }}</div>
          </Link>

          <a
            v-if="[0, 1].includes($page.props.auth.user.role)"
            href="/stock-transfer-returns"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300 block"
          >
            <div class="text-3xl mb-3">🔄</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('sales.transfer_returns') }}</div>
            <div class="text-sm text-gray-600">{{ $t('sales.manage_transfer_returns') }}</div>
          </a>

          <Link
            v-if="[0, 1, 2, 3].includes($page.props.auth.user.role)"
            :href="route('return.index')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">↩️</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('sales.returns') }}</div>
            <div class="text-sm text-gray-600">{{ $t('sales.manage_returns') }}</div>
          </Link>

          <Link
            v-if="[0, 1].includes($page.props.auth.user.role)"
            :href="route('reports.expenses')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">💸</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('sales.supplier_payments') }}</div>
            <div class="text-sm text-gray-600">{{ $t('sales.payment_summary') }}</div>
          </Link>
        </div>
      </div>

      <!-- Report Management -->
      <div
        v-if="activeTab === 'reports' && [0, 1, 2, 3].includes($page.props.auth.user.role)"
        class="px-4 sm:px-6 lg:px-8 mb-8"
      >
        <h3 class="text-lg font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
          <span class="text-2xl">📊</span> {{ $t('dashboard.report_management') }}
        </h3>
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('reports.low-stock-shop')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🏪</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.shop_low_stock') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.shop_low_stock_desc') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('reports.low-stock-store')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🏬</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.store_low_stock') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.store_low_stock_desc') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 2, 3].includes($page.props.auth.user.role)"
            :href="route('reports.stock')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📈</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.stock_report') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.stock_report_desc') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 2].includes($page.props.auth.user.role)"
            :href="route('reports.sales-income')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">💰</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.order_history') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.order_history_desc') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 2, 3].includes($page.props.auth.user.role)"
            :href="route('reports.cash-drawer')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🧾</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.cash_drawer') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.cash_drawer_desc') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('reports.product-movements')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🔀</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.product_movements') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.product_movements_desc') }}</div>
          </Link>

          <Link
            v-if="[0, 1, 3].includes($page.props.auth.user.role)"
            :href="route('reports.product-movement-sales-optimization')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📊</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.sales_optimization') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.sales_optimization_desc') }}</div>
          </Link>

          <Link
            v-if="[0].includes($page.props.auth.user.role)"
            :href="route('reports.activity-log')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📝</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.activity_log') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.activity_log_desc') }}</div>
          </Link>

          <Link
            v-if="[0].includes($page.props.auth.user.role)"
            :href="route('reports.sync')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🔄</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('reports.sync_report') }}</div>
            <div class="text-sm text-gray-600">{{ $t('reports.sync_report_desc') }}</div>
          </Link>
        </div>
      </div>

      <!-- Settings -->
      <div
        v-if="activeTab === 'settings' && ![1, 2, 3].includes($page.props.auth.user.role)"
        class="px-4 sm:px-6 lg:px-8 mb-8"
      >
        <h3 class="text-lg font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
          <span class="text-2xl">🔧</span> {{ $t('dashboard.settings') }}
        </h3>
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
          <Link
            :href="route('settings.app')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">⚙️</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('settings.app_settings') }}</div>
            <div class="text-sm text-gray-600">{{ $t('settings.app_settings_configure') }}</div>
          </Link>

          <Link
            :href="route('settings.sync')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">🔄</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('settings.sync_settings') }}</div>
            <div class="text-sm text-gray-600">{{ $t('settings.sync_settings_desc') }}</div>
          </Link>

          <Link
            v-if="![1].includes($page.props.auth.user.role)"
            :href="route('backup.settings')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">💾</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('settings.database_backup') }}</div>
            <div class="text-sm text-gray-600">{{ $t('settings.database_backup_desc') }}</div>
          </Link>

          <Link
            :href="route('settings.bill')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📄</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('settings.bill_settings') }}</div>
            <div class="text-sm text-gray-600">{{ $t('settings.bill_settings_desc') }}</div>
          </Link>

          <Link
            :href="route('import-export')"
            class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:border-gray-300 hover:-translate-y-0.5 transition-all duration-300"
          >
            <div class="text-3xl mb-3">📁</div>
            <div class="font-semibold text-gray-900 mb-1">{{ $t('settings.import_export') }}</div>
            <div class="text-sm text-gray-600">{{ $t('settings.import_export_desc') }}</div>
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
a {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}
</style>
