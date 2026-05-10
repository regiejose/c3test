import { useEffect, useState } from 'react'

export default function FooterMenu({ endpoint }) {
  const [data, setData] = useState(null)

  useEffect(() => {
    async function loadData() {

      // Request a token.
      const tokenResponse = await fetch('/v1/api/jwt/generate',{
        method: "POST",
        body: JSON.stringify({ url: endpoint }),
      });
      const tokRes = await tokenResponse.text();
      const parseRes = JSON.parse(tokRes);

      // Call protected API
      const response = await fetch(endpoint, {
        method: 'GET',
        headers: {
          Authorization: `Bearer ${parseRes.token}`
        }
      });
  
      const json = await response.json();
      setData(json);
    }
  
    loadData();

  }, [endpoint])

  if (!data) return <p>Loading...</p>

  const menuItems = data.menuItems ?? []

  return (
    <div class="flex flex-col text-sm space-y-2.5">
      <h2 className="font-semibold mb-5 text-gray-800">
        {data.title ?? ''}
      </h2>

      {menuItems.map((item) => (
        // I use A tag instead of <Link> from react-router-dom.
        // because, Link tag is breaking in Drupal.
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