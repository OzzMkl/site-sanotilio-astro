document.addEventListener("DOMContentLoaded", () => {
  const scrollElements: NodeListOf<Element> =
    document.querySelectorAll(".js-scroll");

  const observer = new IntersectionObserver(
    (entries: IntersectionObserverEntry[], observer: IntersectionObserver) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.2,
    }
  );

  scrollElements.forEach((el) => {
    observer.observe(el);
  });
});
