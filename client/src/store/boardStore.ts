import { writable } from 'svelte/store'

export type BoardType = {
  threadId: string
  title: string
  lastModified: string
}

export const boardStore = writable<BoardType[]>([])
