// components.jsx — building blocks

function Eyebrow({ children }) {
  return <div className="eyebrow">{children}</div>;
}

function Nav() {
  return (
    <header className="nav">
      <div className="wrap nav-row">
        <a href="#top" className="brand">
          <span className="dot"></span>
          <span>JOHN&nbsp;RUDOLPH&nbsp;DREXLER</span>
        </a>
        <nav className="navlinks">
          <a href="#timeline">Endorsements</a>
          <a href="#voice">Talks &amp; podcasts</a>
          <a href="#beyond">Beyond work</a>
        </nav>
        <a href="#contact" className="nav-cta">Let's chat</a>
      </div>
    </header>
  );
}

function Hero({ onPickScope }) {
  return (
    <section className="hero" id="top" data-screen-label="01 Hero">
      <div className="wrap hero-grid">
        <div className="hero-text">
          <h1>
            Technical Product Manager at Datadog, game designer, <em>and speaker.</em>
          </h1>
          <div className="ctas">
            <a className="btn btn-primary" href="#contact">Let's chat <span className="arrow">→</span></a>
          </div>
          <div className="hero-meta">
            <span>Based in NYC</span>
          </div>
        </div>
        <figure className="hero-photo">
          <img src="/images/headshot.png" alt="John Rudolph Drexler" />
        </figure>
      </div>
    </section>
  );
}

function Avatar({ initials }) {
  return <div className="avatar" aria-hidden="true">{initials}</div>;
}

function QuoteCard({ q }) {
  return (
    <figure className="quote">
      <div className="quote-photo" style={q.img ? {backgroundImage:`url(${q.img})`} : null}>
        {!q.img && <span className="quote-photo-fallback">{q.initials}</span>}
      </div>
      <div className="quote-content">
        <div className="mark" aria-hidden="true">&ldquo;</div>
        <blockquote className="body" dangerouslySetInnerHTML={{ __html: q.body }} />
        <figcaption className="attr">
          <div className="who">
            <div className="name">
              <a className="lnk" href={q.nameHref || "#"} target="_blank" rel="noreferrer">{q.name}</a>
            </div>
            <div className="role" dangerouslySetInnerHTML={{
              __html: `${q.role} &middot; <a class="lnk" href="${q.companyHref || "#"}" target="_blank" rel="noreferrer">${q.company}</a>`
            }} />
          </div>
        </figcaption>
      </div>
    </figure>
  );
}

function TimelineSection() {
  return (
    <section id="timeline" data-screen-label="02 Endorsements">
      <div className="wrap">
        <div className="sec-head">
          <Eyebrow>Endorsements</Eyebrow>
          <h2>
            I'll let the founders <em>speak for me.</em>
          </h2>
        </div>

        <div className="tl">
          <div className="tl-rail" aria-hidden="true"></div>
          {window.ERAS.map((era, i) => (
            <div className="tl-era" key={i} data-current={era.current ? "true" : "false"}>
              <div className="tl-dot" aria-hidden="true"></div>
              <div className="tl-year">{era.year}</div>
              <h3 className="tl-title">{era.title}</h3>
              <p className="tl-blurb">{era.blurb}</p>
              <div className={"quotes" + (era.cols === 2 ? " cols-2" : "")}>
                {era.quotes.map((q, j) => <QuoteCard key={j} q={q} />)}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function VideoCard({ v }) {
  const thumb = v.thumb || `https://i.ytimg.com/vi/${v.yt}/hqdefault.jpg`;
  return (
    <a className="video" href={v.href} target="_blank" rel="noreferrer">
      <div className="thumb">
        <img src={thumb} alt="" loading="lazy" />
        <div className="play" aria-hidden="true">
          <div className="play-btn">
            <svg width="22" height="22" viewBox="0 0 22 22"><path d="M6 4 L18 11 L6 18 Z" fill="currentColor"/></svg>
          </div>
        </div>
      </div>
      <div className="meta">
        <h4 className="ttl">{v.title}<br/><span style={{fontFamily:"var(--sans)",fontSize:"13.5px",color:"var(--ink-3)",letterSpacing:0,fontStyle:"normal",fontWeight:400}}>{v.sub}</span></h4>
        <span className="where">{v.where}</span>
      </div>
    </a>
  );
}

function PodcastRow({ p }) {
  return (
    <a className="pod" href={p.href} target="_blank" rel="noreferrer">
      {p.img
        ? <div className="cover cover-img" style={{backgroundImage:`url(${p.img})`}} aria-hidden="true"></div>
        : <div className="cover">{p.sym}</div>}
      <div className="body">
        <h4 className="name">{p.name}</h4>
        <p className="desc">{p.desc}</p>
      </div>
      <div className="arr">↗</div>
    </a>
  );
}

function VoiceSection() {
  return (
    <section id="voice" data-screen-label="04 Voice">
      <div className="wrap">
        <div className="sec-head">
          <Eyebrow>Talks &amp; podcasts</Eyebrow>
          <h2>What I sound like <em>at the conference, on a call.</em></h2>
        </div>
        <div className="voice-grid voice-grid-videos">
          {window.VIDEOS.map((v, i) => <VideoCard key={i} v={v} />)}
          <div className="podcasts-card">
            <div className="podcasts-card-head">Podcasts</div>
            {window.PODCASTS.map((p, i) => <PodcastRow key={i} p={p} />)}
          </div>
        </div>
      </div>
    </section>
  );
}

function Beyond() {
  return (
    <section id="beyond" className="beyond" data-screen-label="05 Beyond">
      <div className="wrap">
        <div className="sec-head">
          <Eyebrow>Beyond work</Eyebrow>
          <h2>My life, <em>outside of the job.</em></h2>
        </div>

        <div className="beyond-list-v2">
          {window.BEYOND.map((b, i) => (
            <a key={i} className="brow" href={b.href} target={b.href.startsWith("http") ? "_blank" : undefined} rel="noreferrer">
              <span className="brow-img" style={{backgroundImage:`url(${b.img})`}} aria-hidden="true"></span>
              <span className="brow-body">
                <span className="brow-ttl">{b.title}</span>
                <span className="brow-sub" dangerouslySetInnerHTML={{__html: b.sub}} />
              </span>
              <span className="brow-arr">{b.arr}</span>
            </a>
          ))}
          <div className="socials-card">
            <div className="socials-card-head">Find me elsewhere</div>
            <div className="social-row">
              {window.SOCIALS.map((s, i) => (
                <a key={i} className="soc-icon" href={s.href} target="_blank" rel="noreferrer" title={s.label} aria-label={s.label}>
                  <svg viewBox={s.viewBox} width="22" height="22" fill="currentColor" aria-hidden="true"><path d={s.path}/></svg>
                </a>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

function Contact() {
  return (
    <section id="contact" className="contact" data-screen-label="06 Contact">
      <div className="wrap contact-grid">
        <div>
          <Eyebrow>Let's chat</Eyebrow>
          <h2>Let&rsquo;s <em>chat.</em></h2>
          <p className="blurb">
            Grab 30 minutes on my calendar.
          </p>
        </div>
        <div className="contact-cta">
          <a className="btn btn-primary" href="https://calendly.com/john-9hy/30min" target="_blank" rel="noreferrer">
            Book a 30-min intro call <span className="arrow">→</span>
          </a>
        </div>
      </div>
    </section>
  );
}

function Footer() {
  return (
    <footer>
      <div className="wrap foot">
        <div className="col">
          <h4>Site</h4>
          <a href="#timeline">Endorsements</a>
          <a href="#voice">Talks &amp; podcasts</a>
          <a href="#beyond">Beyond work</a>
          <a href="#contact">Contact</a>
        </div>
      </div>
      <div className="wrap footnote">
        <span>© 2026 John Rudolph Drexler</span>
        <span>johnrudolphdrexler.com</span>
      </div>
    </footer>
  );
}

Object.assign(window, { Nav, Hero, TimelineSection, VoiceSection, Beyond, Contact, Footer });
