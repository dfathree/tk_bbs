<script lang="ts">
  import { onMount } from 'svelte'
  import { page as storePage } from '$app/stores'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import { threadStore } from '../../../store/threadStore'
  import ParentBox from '../../../components/Parent/index.svelte'
  import ResBox from '../../../components/Res/index.svelte'
  import type { ResType, ThreadType } from '../../../store/threadStore'

  let threadId = ''
  const fetchReses = async () => {
    const response = await fetch(
      `${PUBLIC_API_SERVER}/api/thread/get.php?threadId=${threadId}&page=${$threadStore.page + 1}`,
    )
    const data: ThreadType = await response.json()
    threadStore.update(value => ({
      ...data,
      reses: [
        ...value.reses,
        ...data.reses.map((res: ResType, index: number) => ({
          ...res,
          resNum: data.total - (data.page - 1) * data.perPage - index,
        })),
      ],
    }))
  }

  onMount(() => {
    const unsubscribe = storePage.subscribe(async $page => {
      threadId = $page.params.threadId
      threadStore.clear()
      fetchReses()
    })

    const bottomElement = document.getElementById('bottomElement')
    const observer = new IntersectionObserver(
      entries => {
        const [entry] = entries
        if (entry.isIntersecting && $threadStore.total >= $threadStore.page * $threadStore.perPage) {
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
  <div class="text-2xl mb-2">{$threadStore.parent.title}</div>
  <div class="mr-4">
    <ParentBox parent={$threadStore.parent} />
    {#each $threadStore.reses as res}
      <ResBox {threadId} {res} />
    {/each}
  </div>

  <div id="bottomElement"></div>
</div>
