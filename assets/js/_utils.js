
export function getMetaContent(name) {
  const element = document.querySelector<HTMLMetaElement>(`meta[name="${name}"]`);
  if (element === null) { return null }
  return element.content;
}
