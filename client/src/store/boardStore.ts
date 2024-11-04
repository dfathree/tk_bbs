import { writable } from 'svelte/store'
import { PUBLIC_API_SERVER } from '$env/static/public'

export type BoardType = {
  threadId: string
  title: string
  lastModified: string
}

const { subscribe, set, update } = writable<BoardType[]>([])

const fetchFromNetwork = async () => {
  const response = await fetch(`${PUBLIC_API_SERVER}/api/board/get.php`)
  const { threads }: { threads: BoardType[] } = await response.json()
  update(() => threads)
}

export const boardStore = {
  subscribe,
  set,
  update,
  fetch: fetchFromNetwork,
}
