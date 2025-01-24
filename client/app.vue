<script setup lang="ts">
const router = useRouter()

useHead({
  htmlAttrs: {
    lang: 'en',
  },
  title: 'Bruning Sistemas',
  titleTemplate: title => title !== 'Bruning Sistema' ? `${title} · Bruning Sistema` : title,
  meta: [
    { name: 'description', content: 'Cadastro de Funcionários Bruning ✨' },
    { property: 'og:image', content: 'https://movies.nuxt.space/social-card.png' },
  ],
  link: [
    {
      rel: 'icon',
      type: 'image/png',
      href: '/bruning.png',
    },
  ],
})
</script>

<template>
  <div>
      <NuxtPage/>
  </div>
</template>
