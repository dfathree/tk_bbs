<script lang="ts">
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  export let resId: string
  export let filename: string

  $: url = `${PUBLIC_API_SERVER}/api/image/get.php?threadId=${threadId}&resId=${resId}&filename=${filename}`
</script>

<a href={url} target="_blank">
  <img src={url} alt="画像" class="w-80" />
</a>
