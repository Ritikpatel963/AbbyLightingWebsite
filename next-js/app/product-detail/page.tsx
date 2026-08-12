"use client";

import { useEffect, useRef } from "react";

export default function ProductDetail() {
  const galleryRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    // Simple mock script for gallery thumbs if needed
    const gallery = galleryRef.current;
    if (!gallery) return;
    const thumbs = Array.from(gallery.querySelectorAll(".product-thumbs button"));
    const stageImg = document.querySelector(".product-stage img") as HTMLImageElement;
    
    thumbs.forEach(thumb => {
      thumb.addEventListener("click", () => {
        thumbs.forEach(t => t.classList.remove("active"));
        thumb.classList.add("active");
        const img = thumb.querySelector("img");
        if (img && stageImg) {
          stageImg.src = img.src;
        }
      });
    });
  }, []);

  return (
    <div className="product-page">
      <div className="product-shell">
        <div className="site-breadcrumb site-breadcrumb--on-light product-breadcrumb product-reveal">
          <a href="/">Home</a> / Decorative / Quarry / Cymbal S
        </div>
        <section className="product-top">
          <div className="product-gallery product-reveal" ref={galleryRef}>
            <div className="thumb-carousel">
              <button className="gallery-arrow gallery-prev" aria-label="Previous product images">‹</button>
              <div className="product-thumbs">
                <button className="active"><img src="/images/cymbal/image-01.jpg" alt=""/></button>
                <button className=""><img src="/images/cymbal/image-02.jpg" alt=""/></button>
                <button className=""><img src="/images/cymbal/image-03.jpg" alt=""/></button>
                <button className=""><img src="/images/cymbal/image-04.jpg" alt=""/></button>
                <button className=""><img src="/images/cymbal/image-05.jpg" alt=""/></button>
              </div>
              <button className="gallery-arrow gallery-next" aria-label="Next product images">›</button>
            </div>
            <button className="product-stage ">
              <img src="/images/cymbal/image-01.jpg" alt="Cymbal S pendant"/>
              <span>↗  Zoom</span>
            </button>
          </div>
          <div className="product-info product-reveal product-delay-1">
            <p className="product-tag">Quarry Collection · Pendant Light</p>
            <h1>Cymbal S</h1>
            <p className="product-desc">A sculptural pendant inspired by the quiet materiality of stone. Cymbal S pairs a hand-finished terrazzo shade with a softly diffused glass globe.</p>
            <div className="product-option ">
              <strong>Colour</strong>
              <div className="swatches ">
                <button className="active finish-1"><i style={{"--finish":"#f2f0ea"} as any}></i><span>White</span></button>
                <button className=" finish-2"><i style={{"--finish":"#1f1f1f"} as any}></i><span>Black</span></button>
                <button className=" finish-3"><i style={{"--finish":"#9c482a"} as any}></i><span>Terra</span></button>
                <button className=" finish-4"><i style={{"--finish":"#b69665"} as any}></i><span>Sand</span></button>
              </div>
            </div>
            <div className="product-option">
              <strong>Size</strong>
              <div className="size-options">
                <button className="active">Small</button>
                <button className="">Medium</button>
                <button className="">Large</button>
              </div>
            </div>
            <div className="product-sku">
              <span>SKU</span><b>QRY-CYM-350-WHT</b>
            </div>
            <button className="product-enquire">Enquire Now</button>
            <p className="product-help">
              <svg stroke="currentColor" fill="currentColor" strokeWidth="0" viewBox="0 0 448 512" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
              </svg> <span>Need bulk orders or custom solutions? <a href="https://wa.me/" target="_blank">Talk to us.</a></span>
            </p>
          </div>
        </section>
      </div>
      <section className="collection-band">
        <img src="/images/cymbal/image-02.jpg" alt="Quarry collection"/>
        <div className="product-reveal">
          <p>The collection</p>
          <h2>Part of <em>Quarry</em></h2>
          <span>Cymbal S belongs to the Quarry Collection — sculptural lighting in stone, terrazzo, cement and metal, shaped to celebrate material character rather than conceal it. Crafted by nature, refined by design.</span>
          <a href="#">Explore Collection</a>
        </div>
      </section>
      <section className="product-specs">
        <h2 className="product-reveal">About this product</h2>
        <div className="spec-grid product-reveal product-delay-1">
          <section className="spec-accordion open">
            <button type="button" aria-expanded="true"><span>Specifications</span><i>−</i></button>
            <div className="spec-body">
              <div>
                <p><b>Category</b><span>Pendant light</span></p>
                <p><b>Available in finishes</b><span>White, Black, Terra, Sand</span></p>
                <p><b>Material</b><span>Cement, Metal</span></p>
              </div>
            </div>
          </section>
          <section className="spec-accordion open">
            <button type="button" aria-expanded="true"><span>Dimensions</span><i>−</i></button>
            <div className="spec-body">
              <div>
                <p><b>Diameter</b><span>350 mm</span></p>
                <p><b>Height</b><span>260 mm</span></p>
                <p><b>Canopy</b><span>Ø 83mm, H 35mm</span></p>
                <p><b>Cable</b><span>1.5 m</span></p>
              </div>
            </div>
          </section>
          <section className="spec-accordion open">
            <button type="button" aria-expanded="true"><span>Light source &amp; specifications</span><i>−</i></button>
            <div className="spec-body">
              <div>
                <p><b>Light source</b><span>E27 · LED compatible</span></p>
                <p><b>Colour temperature</b><span>2700–3000K warm white</span></p>
                <p><b>Input</b><span>220–240V AC · 50/60 Hz</span></p>
              </div>
            </div>
          </section>
          <details open>
            <summary>Downloads</summary>
            <div className="download-row">
              <button>Datasheet (PDF)</button>
              <button>Installation guide</button>
              <button>Care Instructions</button>
            </div>
          </details>
        </div>
      </section>
      <section className="related-section">
        <h2 className="product-reveal">Related products</h2>
        <div className="related-carousel">
          <button className="related-arrow related-prev" aria-label="Previous related products">‹</button>
          <div className="related-track">
            <a className="product-reveal product-delay-1" href="#"><img src="/images/cymbal/image-03.jpg" alt="Cymbal M"/><h3>Cymbal M</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-2" href="#"><img src="/images/cymbal/image-04.jpg" alt="Apex"/><h3>Apex</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-05.jpg" alt="Canopy"/><h3>Canopy</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-06.jpg" alt="Node"/><h3>Node</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-01.jpg" alt="Cymbal L"/><h3>Cymbal L</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-03.jpg" alt="Quarry Drop"/><h3>Quarry Drop</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-04.jpg" alt="Disc"/><h3>Disc</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-05.jpg" alt="Halo"/><h3>Halo</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-06.jpg" alt="Terra Bell"/><h3>Terra Bell</h3><span>Decorative · Pendant Light</span></a>
            <a className="product-reveal product-delay-3" href="#"><img src="/images/cymbal/image-01.jpg" alt="Stone Arc"/><h3>Stone Arc</h3><span>Decorative · Pendant Light</span></a>
          </div>
          <button className="related-arrow related-next" aria-label="Next related products">›</button>
        </div>
      </section>
    </div>
  );
}
