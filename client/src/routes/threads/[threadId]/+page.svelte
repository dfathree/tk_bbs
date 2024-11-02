<script lang="ts">
  import { onMount } from 'svelte'
  import { page as storePage } from '$app/stores'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import ParentBox from '../../../components/Parent/index.svelte'
  import ResBox from '../../../components/Res/index.svelte'
  import { threadStore } from '../../../store/threadStore'
  import type { CommentType, ParentType, ResType, ThreadType } from '../../../store/threadStore'

  let threadId = ''
  const fetchReses = async () => {
    if ($threadStore.total < $threadStore.page * $threadStore.perPage) {
      return
    }
    const response = await fetch(
      `${PUBLIC_API_SERVER}/api/thread/get.php?threadId=${threadId}&page=${$threadStore.page + 1}`,
    )
    const data: ThreadType = await response.json()
    threadStore.update(() => ({
      ...data,
      reses: data.reses.map((res: ResType, index: number) => ({
        ...res,
        resNum: data.total - (data.page - 1) * data.perPage - index,
      })),
    }))
  }

  const handleCreateComment = (event: CustomEvent<CommentType & { resId: string }>) => {
    const { resId, commentId, content, createdAt } = event.detail
    threadStore.updateReses(reses =>
      reses.map(res => {
        if (res.resId === resId) {
          res.comments.push({ commentId, content, createdAt })
        }
        return res
      }),
    )
  }

  const handleEditParent = (event: CustomEvent<Omit<ParentType, 'resNum' | 'comments'>>) => {
    const { title, content } = event.detail
    $threadStore.parent.title = title
    $threadStore.parent.content = content
  }

  const handleEditRes = (event: CustomEvent<{ resId: string; content: string; images: string[] }>) => {
    const { resId, content, images } = event.detail
    threadStore.updateReses(reses =>
      reses.map(res => {
        if (res.resId === resId) {
          res.content = content
          res.images = images
        }
        return res
      }),
    )
  }

  const handleDeleteRes = (event: CustomEvent<{ resId: string }>) => {
    const { resId } = event.detail
    threadStore.updateReses(reses => reses.filter(res => res.resId !== resId))
  }

  const handleDeleteComment = (event: CustomEvent<{ resId: string; commentId: string }>) => {
    const { resId, commentId } = event.detail
    threadStore.updateReses(reses =>
      reses.map(res => {
        if (res.resId === resId) {
          res.comments = res.comments.filter(comment => comment.commentId !== commentId)
        }
        return res
      }),
    )
  }

  onMount(() => {
    const unsubscribe = storePage.subscribe(async $page => {
      threadId = $page.params.threadId
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
  <div class="text-2xl mb-2">{$threadStore.parent.title}</div>
  <div class="mr-4">
    <ParentBox parent={$threadStore.parent} on:editParent={handleEditParent} />
    {#each $threadStore.reses as res}
      <ResBox
        {threadId}
        {res}
        on:createComment={handleCreateComment}
        on:editRes={handleEditRes}
        on:deleteRes={handleDeleteRes}
        on:deleteComment={handleDeleteComment}
      />
    {/each}
  </div>

  <div id="bottomElement"></div>
</div>
