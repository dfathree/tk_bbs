<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, Dropdown, DropdownItem } from 'flowbite-svelte'
  import { BarsOutline } from 'flowbite-svelte-icons'
  import EditParentButton from './EditParentButton.svelte'

  export let threadId: string
  let openDropdown = false
</script>

<Button class="p-1" size="xs" color="light" pill><BarsOutline /></Button>
<Dropdown bind:open={openDropdown}>
  <EditParentButton {threadId} on:editParent on:close={() => (openDropdown = false)}>編集</EditParentButton>
  <DropdownItem>削除</DropdownItem>
</Dropdown>
