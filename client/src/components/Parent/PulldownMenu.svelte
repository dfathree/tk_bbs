<script lang="ts">
  import { Button, Dropdown, DropdownItem } from 'flowbite-svelte'
  import { BarsOutline } from 'flowbite-svelte-icons'
  import DeleteResButton from '../Res/DeleteResButton.svelte'
</script>

<Button class="p-1" size="xs" color="light" pill><BarsOutline /></Button>
<Dropdown>
  <DropdownItem>編集</DropdownItem>
  <DropdownItem>削除</DropdownItem>
</Dropdown>
