import type { Comment } from '../Comment/types'

export type Res = {
  resNum?: number
  resId: string
  content: string
  createdAt: string
  images: string[]
  comments: Comment[]
}
