"use client";

import { useEffect, useRef } from "react";

export default function Home() {
  const heroRef = useRef<HTMLElement>(null);

  useEffect(() => {
    const hero = heroRef.current;
    if (!hero || hero.dataset.carouselReady === "true") return;

    const track = hero.querySelector(".hero-track") as HTMLElement;
    const slides = Array.from(hero.querySelectorAll("[data-hero-slide]"));
    const dots = Array.from(hero.querySelectorAll(".dots button"));
    const previous = hero.querySelector('[aria-label="Previous hero banner"]');
    const next = hero.querySelector('[aria-label="Next hero banner"]');
    if (!track || slides.length < 2 || dots.length !== slides.length || !previous || !next) return;

    hero.dataset.carouselReady = "true";
    let currentIndex = 0;
    let autoplayTimer: number = 0;
    let activationFrame = 0;
    let touchStartX: number | null = null;
    let touchStartY: number | null = null;

    const render = (nextIndex: number, restartAutoplay = true, immediate = false) => {
      currentIndex = (nextIndex + slides.length) % slides.length;
      if (activationFrame) window.cancelAnimationFrame(activationFrame);
      slides.forEach(slide => slide.classList.remove("is-active"));
      track.style.transform = "translate3d(" + (-currentIndex * 100) + "%, 0, 0)";
      slides.forEach((slide, index) => slide.setAttribute("aria-hidden", String(index !== currentIndex)));
      dots.forEach((dot, index) => {
        const isActive = index === currentIndex;
        dot.classList.toggle("active", isActive);
        if (isActive) dot.setAttribute("aria-current", "true");
        else dot.removeAttribute("aria-current");
      });
      const activatedIndex = currentIndex;
      if (immediate) {
        slides[activatedIndex].classList.add("is-active");
      } else {
        activationFrame = window.requestAnimationFrame(() => {
          activationFrame = window.requestAnimationFrame(() => {
            if (activatedIndex === currentIndex) slides[activatedIndex].classList.add("is-active");
          });
        });
      }
      if (restartAutoplay) startAutoplay();
    };

    const stopAutoplay = () => {
      if (autoplayTimer) window.clearInterval(autoplayTimer);
      autoplayTimer = 0;
    };

    const startAutoplay = () => {
      stopAutoplay();
      if (document.hidden || window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
      autoplayTimer = window.setInterval(() => render(currentIndex + 1, false), 6000);
    };

    previous.addEventListener("click", () => render(currentIndex - 1));
    next.addEventListener("click", () => render(currentIndex + 1));
    dots.forEach((dot, index) => dot.addEventListener("click", () => render(index)));

    hero.addEventListener("mouseenter", stopAutoplay);
    hero.addEventListener("mouseleave", startAutoplay);
    hero.addEventListener("focusin", stopAutoplay);
    hero.addEventListener("focusout", (event: any) => {
      if (!hero.contains(event.relatedTarget)) startAutoplay();
    });

    hero.addEventListener("touchstart", (event: any) => {
      const touch = event.touches[0];
      if (!touch) return;
      touchStartX = touch.clientX;
      touchStartY = touch.clientY;
      stopAutoplay();
    }, { passive: true });

    hero.addEventListener("touchend", (event: any) => {
      const touch = event.changedTouches[0];
      if (!touch || touchStartX === null || touchStartY === null) {
        startAutoplay();
        return;
      }
      const deltaX = touch.clientX - touchStartX;
      const deltaY = touch.clientY - touchStartY;
      touchStartX = null;
      touchStartY = null;
      if (Math.abs(deltaX) >= 45 && Math.abs(deltaX) > Math.abs(deltaY)) {
        render(currentIndex + (deltaX < 0 ? 1 : -1));
      } else {
        startAutoplay();
      }
    }, { passive: true });

    hero.addEventListener("touchcancel", () => {
      touchStartX = null;
      touchStartY = null;
      startAutoplay();
    }, { passive: true });

    const handleVisibilityChange = () => {
      if (document.hidden) stopAutoplay();
      else startAutoplay();
    };
    document.addEventListener("visibilitychange", handleVisibilityChange);

    // Intersection Observer for .reveal elements
    const revealElements = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          // We can optionally unobserve the element after it becomes visible
          observer.unobserve(entry.target);
        }
      });
    }, {
      root: null,
      rootMargin: '0px',
      threshold: 0.15
    });

    revealElements.forEach(el => revealObserver.observe(el));

    render(0, false, true);
    startAutoplay();

    return () => {
      stopAutoplay();
      document.removeEventListener("visibilitychange", handleVisibilityChange);
      revealObserver.disconnect();
    };
  }, []);

  return (
    <>
      <div id="spotlight" aria-hidden="true"></div>
      
      <section className="hero" data-hero-carousel="true" ref={heroRef}>
        <div className="hero-track">
          <div className="hero-slide decorative " data-hero-slide="true" aria-hidden="false">
            <div className="hero-copy">
              <h1 className="display">Designed for <em>beautiful spaces</em></h1>
              <p>Decorative lighting that brings every interior to life.</p>
              <a className="btn" href="/#arrivals">
                <span className="cta-d">Explore Decorative</span>
                <span className="cta-m">Enter Decoratives</span>
              </a>
            </div>
          </div>
          <div className="hero-slide architectural has-media" data-hero-slide="true" aria-hidden="true">
            <div className="hero-media-fallback architectural" aria-hidden="true"></div>
            <picture className="hero-media">
              <source media="(max-width: 600px)" srcSet="/images/figma-update/hero-architecture-mobile-frame138.png" />
              <img src="/images/figma-update/hero-architecture-desktop.png" alt="" loading="eager" />
            </picture>
            <div className="hero-media-scrim" aria-hidden="true"></div>
            <div className="hero-copy">
              <h1 className="display">Shaping the <em>art of light</em></h1>
              <p>Precision architectural lighting for beautifully designed spaces.</p>
              <a className="btn" href="/#worlds">
                <span className="cta-d">Explore Architecture</span>
                <span className="cta-m">Explore Architecture</span>
              </a>
            </div>
          </div>
          <div className="hero-slide sigma has-media" data-hero-slide="true" aria-hidden="true">
            <div className="hero-media-fallback sigma" aria-hidden="true"></div>
            <picture className="hero-media">
              <source media="(max-width: 600px)" srcSet="/images/figma-update/hero-sigma-mobile-frame145.png" />
              <img src="/images/figma-update/hero-sigma-desktop.png" alt="" loading="eager" />
            </picture>
            <div className="hero-media-scrim" aria-hidden="true"></div>
            <div className="hero-copy">
              <h1 className="display">Meet the <em>Sigma range</em></h1>
              <p>A modular lighting system with precision optics and a unified ceiling aesthetic.</p>
              <a className="btn" href="/#arrivals">
                <span className="cta-d">Learn More</span>
                <span className="cta-m">Learn More</span>
              </a>
            </div>
          </div>
        </div>
        <button className="hero-arrow hero-arrow-previous" type="button" aria-label="Previous hero banner">‹</button>
        <button className="hero-arrow hero-arrow-next" type="button" aria-label="Next hero banner">›</button>
        <div className="dots">
          <button className="active" aria-current="true" aria-label="Show decorative banner"></button>
          <button className="" aria-label="Show architectural banner"></button>
          <button className="" aria-label="Show sigma banner"></button>
        </div>
      </section>

      <section className="section" id="worlds">
        <div className="shell">
          <div className="section-head reveal">
            <h2>Four worlds of light</h2>
          </div>
          <div className="world-grid">
            <a className="world reveal" style={{"--i":0} as any} href="/#arrivals">
              <div className="photo">
                <img className="world-light world-light-off" src="/images/world-architectural-off.png" alt="Architectural switched off" />
                <img className="world-light world-light-on" src="/images/world-architectural-on.png" alt="Architectural switched on" />
              </div>
              <h3>Architectural</h3>
            </a>
            <a className="world reveal" style={{"--i":1} as any} href="/#arrivals">
              <div className="photo">
                <img className="world-light world-light-off" src="/images/world-decorative-off.png" alt="Decorative switched off" />
                <img className="world-light world-light-on" src="/images/world-decorative-on.png" alt="Decorative switched on" />
              </div>
              <h3>Decorative</h3>
            </a>
            <a className="world reveal" style={{"--i":2} as any} href="/#arrivals">
              <div className="photo">
                <img className="world-light world-light-off" src="/images/world-outdoor-off.png" alt="Outdoor switched off" />
                <img className="world-light world-light-on" src="/images/world-outdoor-on.png" alt="Outdoor switched on" />
              </div>
              <h3>Outdoor</h3>
            </a>
            <a className="world reveal" style={{"--i":3} as any} href="/#arrivals">
              <div className="photo">
                <img className="world-light world-light-off" src="/images/reference/world-smart.png" alt="Smart light switched off" />
              </div>
              <h3>Smart light</h3>
            </a>
          </div>
        </div>
      </section>

      <section className="manufacturing">
        <img className="manufacturing-media section-parallax-media" src="/images/figma-update/manufacturing.png" alt="" />
        <div className="copy reveal">
          <h2>Built on <em>Manufacturing Excellence</em></h2>
          <p>Every Abby luminaire begins long before it reaches a project. Designed, engineered, manufactured and tested entirely in-house, our vertically integrated facility brings every stage of production under one roof.</p>
          <button className="btn" type="button">See How It’s Made</button>
        </div>
      </section>

      <section className="section" id="arrivals">
        <div className="shell">
          <div className="section-head reveal">
            <h2>New Arrivals</h2>
          </div>
          <div className="product-toolbar">
            <div className="filter-chips" role="tablist" aria-label="New arrival categories">
              <button type="button" role="tab" aria-selected="true" className="active">Architectural</button>
              <button type="button" role="tab" aria-selected="false" className="">Decorative</button>
              <button type="button" role="tab" aria-selected="false" className="">Outdoor</button>
            </div>
          </div>
          <div className="products">
            <a className="product reveal is-visible" style={{"--i":0} as any} href="/#contact">
              <div className="photo">
                <img src="/images/reference/product-stellar.png" alt="Stellar 85" />
              </div>
              <h3>Stellar 85</h3>
              <p>Architectural · Pendant Light</p>
            </a>
            <a className="product reveal is-visible" style={{"--i":1} as any} href="/#contact">
              <div className="photo">
                <img src="/images/reference/product-black-jack.png" alt="Black Jack FR" />
              </div>
              <h3>Black Jack FR</h3>
              <p>Architectural · Spot Light</p>
            </a>
            <a className="product reveal is-visible" style={{"--i":2} as any} href="/#contact">
              <div className="photo">
                <img src="/images/world-architectural-on.png" alt="Lucent Track" />
              </div>
              <h3>Lucent Track</h3>
              <p>Architectural · Track Light</p>
            </a>
            <a className="product reveal is-visible" style={{"--i":3} as any} href="/#contact">
              <div className="photo">
                <img src="/images/world-architectural-off.png" alt="Axis Downlight" />
              </div>
              <h3>Axis Downlight</h3>
              <p>Architectural · Downlight</p>
            </a>
          </div>
        </div>
      </section>

      <section className="section projects" id="projects">
        <div className="shell">
          <div className="section-head reveal">
            <h2>Latest projects</h2>
            <a className="project-all-link" href="https://abbylighting.com/projects">
              <span>View all projects</span>
              <span className="project-all-arrow" aria-hidden="true">→</span>
            </a>
          </div>
          <div className="project-grid">
            <figure className="project reveal" style={{"--i":0} as any}>
              <div className="project-placeholder" aria-hidden="true"><span>Project image</span></div>
              <figcaption><strong>Synopsys</strong><span>Workspace | Bangalore</span></figcaption>
            </figure>
            <figure className="project reveal" style={{"--i":1} as any}>
              <div className="project-placeholder" aria-hidden="true"><span>Project image</span></div>
              <figcaption><strong>Tribune</strong><span>Residential | Mumbai</span></figcaption>
            </figure>
            <figure className="project reveal" style={{"--i":2} as any}>
              <div className="project-placeholder" aria-hidden="true"><span>Project image</span></div>
              <figcaption><strong>Conference Room</strong><span>Corporate | Bangalore</span></figcaption>
            </figure>
            <figure className="project reveal" style={{"--i":3} as any}>
              <div className="project-placeholder" aria-hidden="true"><span>Project image</span></div>
              <figcaption><strong>Brookfield Global</strong><span>Office Spaces | Mumbai</span></figcaption>
            </figure>
            <figure className="project reveal" style={{"--i":4} as any}>
              <div className="project-placeholder" aria-hidden="true"><span>Project image</span></div>
              <figcaption><strong>Synopsys Reception</strong><span>Corporate | Bangalore</span></figcaption>
            </figure>
            <figure className="project reveal" style={{"--i":5} as any}>
              <div className="project-placeholder" aria-hidden="true"><span>Project image</span></div>
              <figcaption><strong>Atlas Skilltech University</strong><span>Mumbai</span></figcaption>
            </figure>
          </div>
        </div>
      </section>

      <section className="section" id="clients">
        <div className="shell">
          <div className="section-head reveal">
            <h2>Our Clientele</h2>
          </div>
        </div>
        <div className="marquee reveal">
          <div className="mtrack">
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466660_Abby%20Logo-01.png" alt="Abby Lighting client 1" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466674_Abby%20Logo-02.png" alt="Abby Lighting client 2" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466684_Abby%20Logo-03.png" alt="Abby Lighting client 3" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466692_Abby%20Logo-04.png" alt="Abby Lighting client 4" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466712_Abby%20Logo-05.png" alt="Abby Lighting client 5" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466720_Abby%20Logo-06.png" alt="Abby Lighting client 6" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466732_Abby%20Logo-07.png" alt="Abby Lighting client 7" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466742_Abby%20Logo-08.png" alt="Abby Lighting client 8" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466773_Abby%20Logo-09.png" alt="Abby Lighting client 9" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466785_Abby%20Logo-10.png" alt="Abby Lighting client 10" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466806_Abby%20Logo-11.png" alt="Abby Lighting client 11" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466816_Abby%20Logo-12.png" alt="Abby Lighting client 12" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466825_Abby%20Logo-13.png" alt="Abby Lighting client 13" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466833_Abby%20Logo-14.png" alt="Abby Lighting client 14" /></div>
            <div className="client-logo" aria-hidden="false"><img src="https://abbylighting.com/storage/uploads/clients/1719466842_Abby%20Logo-15.png" alt="Abby Lighting client 15" /></div>
            
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466660_Abby%20Logo-01.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466674_Abby%20Logo-02.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466684_Abby%20Logo-03.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466692_Abby%20Logo-04.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466712_Abby%20Logo-05.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466720_Abby%20Logo-06.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466732_Abby%20Logo-07.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466742_Abby%20Logo-08.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466773_Abby%20Logo-09.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466785_Abby%20Logo-10.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466806_Abby%20Logo-11.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466816_Abby%20Logo-12.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466825_Abby%20Logo-13.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466833_Abby%20Logo-14.png" alt="" /></div>
            <div className="client-logo" aria-hidden="true"><img src="https://abbylighting.com/storage/uploads/clients/1719466842_Abby%20Logo-15.png" alt="" /></div>
          </div>
        </div>
      </section>

      <section className="image-cta">
        <img className="catalogue-media section-parallax-media" src="/images/figma-update/catalogue.png" alt="" />
        <div className="copy reveal">
          <h2>Find the right <em>catalogue.</em></h2>
          <p>Explore our complete collection of architectural, decorative and outdoor lighting, with detailed specifications for every luminaire.</p>
          <a className="btn" href="/#contact">Browse the Library</a>
        </div>
      </section>

      <section className="section" id="news">
        <div className="shell">
          <div className="section-head reveal">
            <h2>In the news</h2>
          </div>
          <div className="news-carousel">
            <button className="news-arrow news-prev" aria-label="Previous news stories">‹</button>
            <div className="news">
              <article className="story reveal" style={{"--i":0} as any}>
                <div className="photo">
                  <img src="/images/reference/news-architectural.png" alt="Abby Lighting unveils its first decorative range" />
                </div>
                <p>ARCHITECTURAL DIGEST</p>
                <h3>Abby Lighting unveils its first decorative range</h3>
              </article>
              <article className="story reveal" style={{"--i":1} as any}>
                <div className="photo">
                  <img src="/images/reference/news-elle.png" alt="Made in India, designed for the world" />
                </div>
                <p>ELLE DECOR INDIA</p>
                <h3>Made in India, designed for the world</h3>
              </article>
              <article className="story reveal" style={{"--i":2} as any}>
                <div className="photo">
                  <img src="/images/reference/news-business.png" alt="Lighting the country’s most iconic workspaces" />
                </div>
                <p>BUSINESS OF HOME</p>
                <h3>Lighting the country’s most iconic workspaces</h3>
              </article>
              <article className="story mobile-story reveal">
                <div className="photo">
                  <img src="/images/reference/news-punekar.png" alt="Rachna Bajaj Joshi" />
                </div>
                <p>PUNEKAR NEWS</p>
                <h3>Abby Lighting Opens New Experience Centre in Pune</h3>
              </article>
            </div>
            <button className="news-arrow news-next" aria-label="Next news stories">›</button>
          </div>
        </div>
      </section>
    </>
  );
}
