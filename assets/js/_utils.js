
export function getMetaContent(name) {
  const element = document.querySelector(`meta[name="${name}"]`);
  return element?.content || null;
}
