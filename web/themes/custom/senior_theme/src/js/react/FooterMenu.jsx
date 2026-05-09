import { useEffect, useState } from 'react'

export default function FooterMenu({ endpoint }) {
  const [data, setData] = useState(null)

  useEffect(() => {
    if (!endpoint) return

    fetch(endpoint)
      .then(res => res.json())
      .then(json => {
        setData(json)
      })
      .catch(console.error)

  }, [endpoint])

  if (!data) return <p>Loading...</p>

  const menuItems = data.menuItems ?? []

  return (
    <div class="flex flex-col text-sm space-y-2.5">
      <h2 className="font-semibold mb-5 text-gray-800">
        {data.title ?? ''}
      </h2>

      {menuItems.map((item) => (
        <a
          key={item.mid}
          href={item.mLink}
          className="hover:text-slate-600 transition"
        >
          {item.mLabel}
        </a>
      ))}
    </div>
  )
}