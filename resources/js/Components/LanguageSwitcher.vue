<script setup>
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();

const toggleLanguage = () => {
    locale.value = locale.value === 'en' ? 'si' : 'en';
    localStorage.setItem('locale', locale.value);
};
</script>

<template>
    <button
        @click="toggleLanguage"
        type="button"
        :title="$t('lang.switch_language')"
        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-gray-500 text-xs font-bold tracking-wide transition-all duration-200 hover:opacity-80 focus:outline-none select-none"
        :class="locale === 'si'
            ? 'bg-blue-600 border-blue-500 text-white'
            : 'bg-gray-700 border-gray-500 text-gray-200'"
    >
        <span :class="locale === 'en' ? 'opacity-100' : 'opacity-50'">EN</span>
        <span class="text-gray-400">|</span>
        <span :class="locale === 'si' ? 'opacity-100' : 'opacity-50'">සිං</span>
    </button>
</template>
