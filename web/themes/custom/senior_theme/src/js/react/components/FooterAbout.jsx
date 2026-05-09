import { useEffect, useState } from 'react'

export default function FooterAbout({ endpoint }) {
  const [data, setData] = useState(null)

  useEffect(() => {
    if (!endpoint) return
    
    fetch(endpoint)
      .then(res => res.json())
      .then(setData)
  }, [endpoint])

  return (
    <p class="text-sm/7">{data?.about || 'Loading...'}</p>
  )
}