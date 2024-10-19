<script lang="ts">
  import { onMount } from 'svelte'
  import { page as storePage } from '$app/stores'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import ParentBox from '../../../components/Parent/index.svelte'
  import type { Parent } from '../../../components/Parent/types'
  import ResBox from '../../../components/Res/index.svelte'
  import CreateResButton from '../../../components/Res/CreateResButton.svelte'
  import type { Res } from '../../../components/Res/types'
  import type { Comment } from '../../../components/Comment/types'

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

  const handleCreateRes = () => {
    page = 0
    fetchReses()
  }

  const handleCreateComment = (event: CustomEvent<Comment & { resId: string }>) => {
    const { resId, commentId, content, createdAt } = event.detail
    reses = reses.map(res => {
      if (res.resId === resId) {
        res.comments.push({ commentId, content, createdAt })
      }
      return res
    })
  }

  const handleDeleteComment = (event: CustomEvent<{ resId: string; commentId: string }>) => {
    const { resId, commentId } = event.detail
    reses = reses.map(res => {
      if (res.resId === resId) {
        res.comments = res.comments.filter(comment => comment.commentId !== commentId)
      }
      return res
    })
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
  <div class="mr-24">
    <ParentBox {parent} />
    {#each reses as res}
      <ResBox {threadId} {res} on:createComment={handleCreateComment} on:deleteComment={handleDeleteComment} />
    {/each}
  </div>

  <CreateResButton {threadId} on:createRes={handleCreateRes} />

  <div id="bottomElement"></div>
</div>
