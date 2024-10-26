export const formatDate = (inputDate: Date | string): string => {
  if (!inputDate) {
    return ''
  }
  const dateObj = new Date(inputDate)
  const year = dateObj.getFullYear()
  const month = `0${dateObj.getMonth() + 1}`.slice(-2)
  const date = `0${dateObj.getDate()}`.slice(-2)
  const hour = `0${dateObj.getHours()}`.slice(-2)
  const minute = `0${dateObj.getMinutes()}`.slice(-2)
  const second = `0${dateObj.getSeconds()}`.slice(-2)
  return `${year}/${month}/${date} ${hour}:${minute}:${second}`
}
