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

const nav = [
  { label: 'Home', to: '/' },
  { label: 'About', to: '/about' },
  { label: 'Parent (index)', to: '/parent' },
  { label: 'Parent (b)', to: '/parent/b' },
  { label: 'Keyed child', onClick: () => router.push(`/parent/reload-${(Math.random() * 100).toFixed()}`) },
  { label: 'Non-Keyed child', onClick: () => router.push(`/parent/static-${(Math.random() * 100).toFixed()}`) },
]
</script>

<template>
  <div>
      <NuxtPage/>
  </div>
</template>
