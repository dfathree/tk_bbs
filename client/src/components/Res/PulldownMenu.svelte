<script lang="ts">
  import { Button, Dropdown, DropdownItem } from 'flowbite-svelte'
  import { BarsOutline } from 'flowbite-svelte-icons'
  import DeleteResButton from './DeleteResButton.svelte'

  export let threadId: string
  export let resId: string = ''
</script>

<Button class="p-1" size="xs" color="light" pill><BarsOutline /></Button>
<Dropdown>
  <DropdownItem>編集</DropdownItem>
  <DeleteResButton {threadId} {resId} on:deleteRes />
</Dropdown>
