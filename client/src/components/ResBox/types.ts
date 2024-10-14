export type Comment = {
  commentId: string
  content: string
  createdAt: string
}
export type Res = {
  resNum?: number
  resId: string
  content: string
  createdAt: string
  comments: Comment[]
}
