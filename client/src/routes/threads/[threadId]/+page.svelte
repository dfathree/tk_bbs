<script lang="ts">
  import { onMount } from 'svelte'
  import { GradientButton } from 'flowbite-svelte'
  import { page as storePage } from '$app/stores'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import ParentBox from '../../../components/ParentBox/index.svelte'
  import type { Parent } from '../../../components/ParentBox/types'
  import ResBox from '../../../components/ResBox/index.svelte'
  import type { Res } from '../../../components/ResBox/types'

  let threadId = ''
  let total = 0
  let page = 0
  let perPage = 10
  let parent: Parent = { threadId: '', title: '', content: '', createdAt: '' }
  let reses: Res[] = []

  const fetchReses = async () => {
    if (total < page * perPage) {
      return
    }
    page += 1
    const response = await fetch(`${PUBLIC_API_SERVER}/api/thread/get.php?threadId=${threadId}&page=${page}`)
    const data = await response.json()
    total = data.total
    page = data.page
    perPage = data.perPage
    parent = data.parent
    data.res.forEach((res: Res, index: number) => {
      const resNum = (page - 1) * perPage + index
      reses[resNum] = { ...res, resNum: total - resNum }
    })
  }

  const init = () => {
    total = 0
    page = 0
    perPage = 10
    parent = { threadId: '', title: '', content: '', createdAt: '' }
    reses = []
  }

  onMount(() => {
    const unsubscribe = storePage.subscribe(async $page => {
      threadId = $page.params.threadId
      init()
      fetchReses()
    })

    const bottomElement = document.getElementById('bottomElement')
    const observer = new IntersectionObserver(
      entries => {
        const [entry] = entries
        if (entry.isIntersecting) {
          fetchReses()
        }
      },
      {
        root: null, // ビューポートをルートとする
        threshold: 0, // 要素が完全にビューポートに入った時にcallbackを呼び出す
      },
    )
    if (bottomElement) {
      observer.observe(bottomElement)
    }

    return () => {
      observer.disconnect()
      unsubscribe()
    }
  })
</script>

<div>
  <div class="text-2xl mb-2">{parent.title}</div>
  <div class="box-container">
    <ParentBox {parent} />
    {#each reses as res}
      <ResBox {res} />
    {/each}
  </div>

  <footer class="flex justify-end items-center">
    <GradientButton color="blue">返信</GradientButton>
  </footer>

  <div id="bottomElement"></div>
</div>

<style>
  .box-container {
    margin-right: 6rem;
  }
  footer {
    position: sticky;
    bottom: 0;
    padding: 1rem 0;
  }
</style>
