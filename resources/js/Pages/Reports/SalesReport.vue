<template>
  <Head title="Sales Report" />

  <AppLayout>
    <div class="min-h-screen bg-gray-50 p-4 sm:p-6">
      <div class="mx-auto max-w-[1500px]">
        <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
          <div class="flex items-center gap-3">
            <button
              @click="goToReportsTab"
              class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              ← {{ $t('common.back') }}
            </button>
            <div>
              <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Sales Report</h1>
              <p class="mt-1 text-sm text-gray-500">Sales performance and invoice details</p>
            </div>
          </div>

          <div class="flex flex-wrap items-center gap-2 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
            <input v-model="startDate" type="date" class="rounded-lg border border-gray-300 px-3 py-2 text-sm" />
            <span class="text-sm text-gray-500">to</span>
            <input v-model="endDate" type="date" class="rounded-lg border border-gray-300 px-3 py-2 text-sm" />
            <button @click="applyFilter" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
              Apply
            </button>
          </div>
        </div>

        <div class="mb-6 flex flex-wrap gap-2">
          <button
            v-for="filter in quickFilters"
            :key="filter.key"
            @click="setQuickFilter(filter.key)"
            :class="[
              'rounded-full border px-3 py-1.5 text-sm font-medium transition',
              activeFilter === filter.key
                ? 'border-blue-600 bg-blue-600 text-white'
                : 'border-gray-200 bg-white text-gray-700 hover:border-blue-300 hover:text-blue-600',
            ]"
          >
            {{ filter.label }}
          </button>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
          <div class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Total Sales</p>
            <p class="mt-2 text-2xl font-bold text-blue-700">{{ currency }} {{ salesTotal }}</p>
          </div>
          <div class="rounded-xl border border-green-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Items Sold</p>
            <p class="mt-2 text-2xl font-bold text-green-700">{{ itemsSoldTotal }}</p>
          </div>
          <div class="rounded-xl border border-orange-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Cost</p>
            <p class="mt-2 text-2xl font-bold text-orange-700">{{ currency }} {{ costTotal }}</p>
          </div>
          <div class="rounded-xl border border-emerald-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Profit</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ currency }} {{ profitTotal }}</p>
          </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
          <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Invoices</h2>
            <span class="text-sm text-gray-500">{{ salesDetails.total }} invoices</span>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px]">
              <thead class="bg-gray-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                  <th class="px-5 py-3">Invoice</th>
                  <th class="px-5 py-3">Date</th>
                  <th class="px-5 py-3">Customer</th>
                  <th class="px-5 py-3">Type</th>
                  <th class="px-5 py-3 text-right">Items</th>
                  <th class="px-5 py-3 text-right">Subtotal</th>
                  <th class="px-5 py-3 text-right">Discount</th>
                  <th class="px-5 py-3 text-right">Sales</th>
                  <th class="px-5 py-3 text-right">Cost</th>
                  <th class="px-5 py-3 text-right">Profit</th>
                  <th class="px-5 py-3 text-center">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr v-for="sale in salesDetails.data" :key="sale.id" class="text-sm text-gray-700 hover:bg-blue-50/40">
                  <td class="px-5 py-3 font-semibold text-blue-700">{{ sale.invoice_no }}</td>
                  <td class="px-5 py-3">{{ formatDate(sale.sale_date) }}</td>
                  <td class="px-5 py-3">{{ sale.customer }}</td>
                  <td class="px-5 py-3">{{ sale.sale_type }}</td>
                  <td class="px-5 py-3 text-right">{{ sale.items_sold }}</td>
                  <td class="px-5 py-3 text-right">{{ currency }} {{ sale.subtotal }}</td>
                  <td class="px-5 py-3 text-right text-orange-600">{{ currency }} {{ sale.discount }}</td>
                  <td class="px-5 py-3 text-right font-semibold">{{ currency }} {{ sale.net_amount }}</td>
                  <td class="px-5 py-3 text-right">{{ currency }} {{ sale.cost }}</td>
                  <td class="px-5 py-3 text-right font-semibold text-emerald-700">{{ currency }} {{ sale.profit }}</td>
                  <td class="px-5 py-3 text-center">
                    <span
                      :class="sale.payment_status === 'Paid'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-amber-100 text-amber-700'"
                      class="rounded-full px-2.5 py-1 text-xs font-semibold"
                    >
                      {{ sale.payment_status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div v-if="salesDetails.data.length === 0" class="py-12 text-center text-sm text-gray-500">
            No sales found for this date range.
          </div>

          <div v-if="salesDetails.links?.length" class="flex flex-wrap justify-end gap-2 border-t border-gray-200 px-5 py-4">
            <button
              v-for="(link, index) in salesDetails.links"
              :key="index"
              v-html="link.label"
              :disabled="!link.url"
              @click="visitPage(link.url)"
              :class="[
                'rounded border px-3 py-1.5 text-sm',
                link.active ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300 bg-white text-gray-700',
                !link.url ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-50',
              ]"
            />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useDashboardNavigation } from '@/composables/useDashboardNavigation';

const props = defineProps({
  salesDetails: Object,
  salesTotal: String,
  itemsSoldTotal: String,
  costTotal: String,
  profitTotal: String,
  startDate: String,
  endDate: String,
});

const page = usePage();
const currency = page.props.currency || '';
const { goToReportsTab } = useDashboardNavigation();
const startDate = ref(props.startDate);
const endDate = ref(props.endDate);
const activeFilter = ref('custom');

const quickFilters = [
  { key: 'today', label: 'Today' },
  { key: 'yesterday', label: 'Yesterday' },
  { key: 'this_week', label: 'This Week' },
  { key: 'last_week', label: 'Last Week' },
  { key: 'this_month', label: 'This Month' },
  { key: 'last_month', label: 'Last Month' },
  { key: 'this_year', label: 'This Year' },
  { key: 'last_year', label: 'Last Year' },
];

const pad = (value) => String(value).padStart(2, '0');
const toDate = (date) => `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;

const setQuickFilter = (key) => {
  const now = new Date();
  let start;
  let end = new Date(now);

  if (key === 'today') {
    start = new Date(now);
  } else if (key === 'yesterday') {
    start = new Date(now);
    start.setDate(now.getDate() - 1);
    end = new Date(start);
  } else if (key === 'this_week') {
    start = new Date(now);
    start.setDate(now.getDate() - now.getDay() + 1);
  } else if (key === 'last_week') {
    end = new Date(now);
    end.setDate(now.getDate() - now.getDay());
    start = new Date(end);
    start.setDate(end.getDate() - 6);
  } else if (key === 'this_month') {
    start = new Date(now.getFullYear(), now.getMonth(), 1);
  } else if (key === 'last_month') {
    start = new Date(now.getFullYear(), now.getMonth() - 1, 1);
    end = new Date(now.getFullYear(), now.getMonth(), 0);
  } else if (key === 'this_year') {
    start = new Date(now.getFullYear(), 0, 1);
  } else if (key === 'last_year') {
    start = new Date(now.getFullYear() - 1, 0, 1);
    end = new Date(now.getFullYear() - 1, 11, 31);
  }

  startDate.value = toDate(start);
  endDate.value = toDate(end);
  activeFilter.value = key;
  applyFilter();
};

const applyFilter = () => {
  router.get(route('reports.sales'), {
    start_date: startDate.value,
    end_date: endDate.value,
  }, {
    preserveState: true,
    preserveScroll: true,
  });
};

const visitPage = (url) => {
  if (url) {
    router.visit(url, { preserveState: true, preserveScroll: true });
  }
};

const formatDate = (date) => {
  if (!date) return '-';
  return new Date(`${date}T00:00:00`).toLocaleDateString();
};
</script>
