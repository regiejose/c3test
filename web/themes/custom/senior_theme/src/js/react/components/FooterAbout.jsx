import { useEffect, useState } from 'react'

export default function FooterAbout({ endpoint }) {
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

  return (
    <p class="text-sm/7">{data?.about || 'Loading...'}</p>
  )
}