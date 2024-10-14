import { json } from '@sveltejs/kit'
import { PUBLIC_API_SERVER } from '$env/static/public'

/** @type {import('./$types').RequestHandler} */
export async function GET({ request }) {
  console.log(request)
  const response = await fetch(`${PUBLIC_API_SERVER}/api/thread/get`)
  const resJson = await response.json()

  return json({ res: resJson })
}
