import { writable } from 'svelte/store'

export type ParentType = {
  threadId: string
  title: string
  content: string
  createdAt: string
}

export type CommentType = {
  commentId: string
  content: string
  createdAt: string
}

export type ResType = {
  resNum?: number
  threadId: string
  resId: string
  content: string
  createdAt: string
  images: string[]
  comments: CommentType[]
}

export type ThreadType = {
  total: number
  page: number
  perPage: number
  parent: ParentType
  reses: ResType[]
}

const initialValue: ThreadType = {
  total: 0,
  page: 0,
  perPage: 10,
  parent: {
    threadId: '',
    title: '',
    content: '',
    createdAt: '',
  },
  reses: [],
}

const { subscribe, set, update } = writable<ThreadType>(initialValue)

export const threadStore = {
  subscribe,
  set,
  update,
  updateReses: (callback: (currentReses: ResType[]) => ResType[]) =>
    update(state => ({ ...state, reses: callback(state.reses) })),
  clear: () => update(() => initialValue),
}
