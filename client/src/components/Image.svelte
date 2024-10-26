<script lang="ts">
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  export let resId: string
  export let filename: string
  export let className = 'w-80'

  $: url = `${PUBLIC_API_SERVER}/api/image/get.php?threadId=${threadId}&resId=${resId}&filename=${filename}`
</script>

<a href={url} target="_blank" class="inline-block mr-4">
  <img src={url} alt="画像" class={className} />
</a>
