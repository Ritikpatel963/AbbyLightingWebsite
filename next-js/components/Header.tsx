export default function Header() {
  return (
    <>
      <header className="sitehead ">
        <div className="wrap">
          <a href="/" className="logo" aria-label="Abby Lighting home">
            <img className="logo-asset" src="/images/abby-logo.png" alt="Abby Lighting" />
          </a>
          <nav aria-label="Primary navigation">
            <ul>
              <li className="has-mega">
                <a className="link" href="/#worlds">
                  Product<span className="caret"></span>
                </a>
                <div className="mega">
                  <div className="mega-panel">
                    <div className="mega-grid">
                      <div className="mgroup m-arch ">
                        <div className="mhead">Architectural</div>
                        <div className="msub">Browse by category</div>
                        <ul>
                          <li><a href="/#arrivals">Spots &amp; Accents</a></li>
                          <li><a href="/#arrivals">Downlights</a></li>
                          <li><a href="/#arrivals">Profiles</a></li>
                          <li><a href="/#arrivals">Track Lights</a></li>
                          <li><a href="/#arrivals">Washers &amp; Grazers</a></li>
                        </ul>
                      </div>
                      <div className="msep"></div>
                      <div className="mgroup m-dec ">
                        <div className="mhead">Decorative <span className="mnew">NEW</span></div>
                        <div className="mcols">
                          <div>
                            <div className="msub">Browse by category</div>
                            <ul>
                              <li><a href="/#arrivals">Chandelier</a></li>
                              <li><a href="/#arrivals">Pendant Lights</a></li>
                              <li><a href="/#arrivals">Wall Lights</a></li>
                              <li><a href="/#arrivals">Floor Lamps</a></li>
                              <li><a href="/#arrivals">Table Lamps</a></li>
                            </ul>
                          </div>
                          <div className="msep sm"></div>
                          <div>
                            <div className="msub">Browse by collection</div>
                            <ul>
                              <li><a href="/product-detail/symphony-iv">Symphony</a></li>
                              <li><a href="/product-detail">Quarry</a></li>
                              <li><a href="/#arrivals">Neoma</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div className="msep lg"></div>
                      <div className="m-worlds">
                        <a className="mgroup m-out " href="/#worlds">
                          <span className="mhead">Outdoor</span>
                        </a>
                        <div className="msep hz"></div>
                        <a className="mgroup m-smart " href="/#worlds">
                          <span className="mhead">Smart Lighting</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li className="has-drop">
                <a className="link" href="/#projects">
                  Our Work<span className="caret"></span>
                </a>
                <div className="drop">
                  <a href="/#projects">Projects</a>
                  <a href="/#clients">Clients</a>
                </div>
              </li>
              <li>
                <a className="link" href="/#news">Inspiration</a>
              </li>
              <li className="has-drop">
                <a className="link" href="/#contact">
                  More<span className="caret"></span>
                </a>
                <div className="drop">
                  <a href="/#contact">About Us</a>
                  <a href="/#contact">Contact Us</a>
                  <a href="/#contact">Careers</a>
                  <a href="/#contact">Catalogues</a>
                </div>
              </li>
            </ul>
          </nav>
          <div className="right">
            <div className="abby-search ">
              <form className="abby-search-form" role="search">
                <span className="abby-search-leading">
                  <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="10.7" cy="10.7" r="6.7"></circle>
                    <path d="m16 16 4.5 4.5"></path>
                  </svg>
                </span>
                <input type="search" placeholder="Search for products, collections and more" aria-label="Search Abby Lighting" autoComplete="off" defaultValue="" />
                <button className="abby-search-go" type="submit" aria-label="Submit search" disabled>
                  →
                </button>
              </form>
              <button type="button" className="abby-search-toggle" aria-label="Open search" aria-expanded="false">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <circle cx="10.7" cy="10.7" r="6.7"></circle>
                  <path d="m16 16 4.5 4.5"></path>
                </svg>
              </button>
            </div>
            <a href="/#contact" className="nav-cta">
              <span className="lbl-d">Get in Touch</span>
              <span className="lbl-m">Contact</span>
            </a>
          </div>
        </div>
      </header>

      <nav className="halo-nav-wrap halo-visible" aria-label="Mobile sections">
        <div className="halo-nav">
          <span className="halo-nav-shadow" aria-hidden="true"></span>
          <svg className="halo-nav-skin" aria-hidden="true" focusable="false" preserveAspectRatio="none">
            <defs>
              <linearGradient id="haloPlateGradient" x1="0" y1="0" x2="0" y2="1">
                <stop className="halo-plate-highlight" offset="0"></stop>
                <stop className="halo-plate-shadow" offset="1"></stop>
              </linearGradient>
              <linearGradient id="haloRimGradient" x1="0" y1="0" x2="0" y2="1">
                <stop className="halo-rim-strong" offset="0"></stop>
                <stop className="halo-rim-soft" offset="1"></stop>
              </linearGradient>
            </defs>
            <path className="halo-nav-plate"></path>
          </svg>
          <span className="halo-orb" aria-hidden="true"></span>
          <div className="halo-tabs" role="tablist" aria-label="Page sections">
            <button className="halo-tab" role="tab" type="button" id="halo-tab-home" aria-selected="false" tabIndex={0}>
              <svg className="halo-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3.5 10.6 12 3.9l8.5 6.7"></path>
                <path d="M5.7 9.2v9.1a1.6 1.6 0 0 0 1.6 1.6h9.4a1.6 1.6 0 0 0 1.6-1.6V9.2"></path>
              </svg>
              <span className="halo-label">Home</span>
            </button>
            <button className="halo-tab" role="tab" type="button" id="halo-tab-product" aria-selected="false" tabIndex={-1}>
              <svg className="halo-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3.4v3.1"></path>
                <path d="M6.6 13.4a5.4 5.4 0 0 1 10.8 0Z"></path>
                <path d="M9.7 13.4a2.3 2.3 0 0 0 4.6 0"></path>
              </svg>
              <span className="halo-label">Products</span>
            </button>
            <button className="halo-tab" role="tab" type="button" id="halo-tab-work" aria-selected="false" tabIndex={-1}>
              <svg className="halo-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3.5 7.1h6.2l2 2h8.8v8.7a1.8 1.8 0 0 1-1.8 1.8H5.3a1.8 1.8 0 0 1-1.8-1.8Z"></path>
                <path d="M3.5 10h17"></path>
              </svg>
              <span className="halo-label">Our Work</span>
            </button>
            <button className="halo-tab" role="tab" type="button" id="halo-tab-inspiration" aria-selected="false" tabIndex={-1}>
              <svg className="halo-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M9.1 16.3a5 5 0 1 1 5.8 0 1.6 1.6 0 0 0-.6 1.2v.4H9.7v-.4a1.6 1.6 0 0 0-.6-1.2Z"></path>
                <path d="M10 20.1h4"></path>
              </svg>
              <span className="halo-label">Inspiration</span>
            </button>
            <button className="halo-tab" role="tab" type="button" id="halo-tab-more" aria-selected="false" tabIndex={-1}>
              <svg className="halo-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4.5 8.2h15"></path>
                <path d="M4.5 12h15"></path>
                <path d="M4.5 15.8h15"></path>
              </svg>
              <span className="halo-label">More</span>
            </button>
          </div>
        </div>
      </nav>

      <button className="menu-backdrop " aria-label="Close menu"></button>
      <div className="msheet  " role="dialog" aria-modal="true" aria-label="Mobile menu">
        <button className="menu-close" aria-label="Close menu">
          <span aria-hidden="true">×</span>
        </button>
        <div className="m-dash"></div>
        <div className="m-title"></div>
        <div className="mobile-menu-list"></div>
      </div>
    </>
  );
}
