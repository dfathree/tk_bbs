import type { Comment } from '../Comment/types'

export type Res = {
  resNum?: number
  threadId: string
  resId: string
  content: string
  createdAt: string
  images: string[]
  comments: Comment[]
}
