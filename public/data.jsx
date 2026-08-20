// data.jsx — content for the site

const ERAS = [
  {
    year: "2014 — 2018",
    title: <>Venture Capital</>,
    blurb: <>My career started with a long stint in Venture Capital. Thousands of hours talking to founders, analyzing companies, and talking strategy.</>,
    quotes: [
      {
        body: "John&rsquo;s years of hands-on work with startups gave him the experience and insight that made him a great product manager. He asks the right questions, thinks critically about business fundamentals, and was an early member of the Sovereign&rsquo;s Capital team.",
        name: "Luke Roush",
        nameHref: "https://www.linkedin.com/in/luke-roush-0a0b694/",
        role: "Co-founder &amp; Co-CEO",
        company: "Sovereign&rsquo;s Capital",
        companyHref: "https://sovereignscapital.com/",
        initials: "LR",
        img: "/images/luke-roush.png",
      },
    ],
  },
  {
    year: "2018 — 2023",
    title: <>Product Manager</>,
    blurb: <>I wanted to get closer to the action, and became a Product Manager. I learned from great people and developed real chops.</>,
    quotes: [
      {
        body: "John was a highly empathetic and effective product manager. He led one of our products from $0&ndash;2M, leading everything from customer interviews to collaboration with engineers and design to make it happen. He was also a team player and a great addition to our team culture.",
        name: "Felicia Curcuru",
        nameHref: "https://www.linkedin.com/in/feliciacurcuru/",
        role: "Founder &amp; CEO",
        company: "Binti",
        companyHref: "https://binti.com",
        initials: "FC",
        img: "/images/felicia-curcuru.png",
      },
    ],
  },
  {
    year: "2023 — 2026",
    title: <>Fractional PM <em>&amp; consultant</em></>,
    blurb: <>With <a className="lnk" href="https://thunk.dev" target="_blank" rel="noreferrer">Thunk</a>, I helped clients build excellent processes that they could actually run themselves.</>,
    quotes: [
      {
        body: "It was a pleasure to work with John to modernize and reimagine Laravel Forge. He brought sharp ideas, great taste, and helped us ship our most ambitious ideas.",
        name: "Taylor Otwell",
        nameHref: "https://twitter.com/taylorotwell",
        role: "Founder &amp; CEO",
        company: "Laravel",
        companyHref: "https://laravel.com",
        initials: "TO",
        img: "/images/taylor-otwell.png",
      },
      {
        body: "John built the actual systems we needed to stay on track. He has a great way of holding the team accountable while keeping everyone connected. The biggest win for me was how much he cleared off my plate &mdash; it gave me the space to focus on the big-picture stuff I&rsquo;m actually responsible for as CEO. If you need someone to streamline your business, John is your guy.",
        name: "Daniel Scott",
        nameHref: "https://www.youtube.com/user/BringYourOwnLaptop",
        role: "Founder &amp; CEO",
        company: "BringYourOwnLaptop",
        companyHref: "https://bringyourownlaptop.com",
        initials: "DS",
        img: "/images/daniel-scott.png",
      },
      {
        body: "John has been instrumental in helping us rethink and improve our software development processes. He&rsquo;s fantastic about asking the right questions, and has pushed us to throw away rituals that never really worked for us and truly commit to the ones that do.",
        name: "Chris Morrell",
        nameHref: "https://cmorrell.com/",
        role: "CEO",
        company: "InterNACHI",
        companyHref: "https://www.nachi.org/",
        initials: "CM",
        img: "/images/chris-morrell.png",
      },
    ],
  },
  {
    year: "2026 — Present",
    current: true,
    title: <>Datadog</>,
    blurb: <>Now I&rsquo;m a Technical Product Manager at <a className="lnk" href="https://www.datadoghq.com/" target="_blank" rel="noreferrer">Datadog</a>.</>,
    quotes: [],
  },
];

const VIDEOS = [
  {
    title: "Don't solve non-problems",
    where: "Laracon EU 2025",
    sub: "A jargon-free primer on product management.",
    href: "https://www.youtube.com/watch?v=RfRp6CwKoVU",
    yt: "RfRp6CwKoVU",
    thumb: "/images/laracon-eu.png",
  },
  {
    title: "Building the high-trust environment",
    where: "Laracon US 2025",
    sub: "Five ways developers can build trust with non-technical colleagues.",
    href: "https://www.youtube.com/watch?v=Zki4d6sHhy4",
    yt: "Zki4d6sHhy4",
    thumb: "/images/laracon-us-2025.png",
  },
  {
    title: "Ship to production on day 1",
    where: "Laracon EU 2026",
    sub: "Ship early, ship often. Why this is the best practice, and practical tips on how to do it.",
    href: "https://www.youtube.com/watch?v=YJmuKPk3d9M&t=11260s",
    yt: "YJmuKPk3d9M",
    thumb: "/images/laracon-eu-2026.jpeg",
  },
];

const PODCASTS = [
  {
    name: "Talking Businessly",
    desc: "A candid conversation about running a software development agency.",
    href: "https://podcast.thunk.dev/",
    sym: "TB",
    img: "/images/talking-businessly.png",
  },
  {
    name: "Notes on Play",
    desc: "A short and sweet game-development log on the hardest design problems I'm facing.",
    href: "https://notesonplay.transistor.fm/",
    sym: "NP",
    img: "/images/notes-on-play.png",
  },
];

const BEYOND = [
  {
    img: "/images/lindsey.jpeg",
    title: "Lindsey",
    sub: "Married to my favorite person, and a brilliant art director.",
    arr: "Her work →",
    href: "https://lindseyevans.work/",
  },
  {
    img: "/images/colossi.jpeg",
    title: "Catacombian",
    sub: "I run an indie board game publisher. My first title <i>Colossi</i> is available now.",
    arr: "Visit →",
    href: "https://www.catacombian.com/",
  },
  {
    img: "/images/jiu-jitsu.jpeg",
    title: "Jiu-Jitsu",
    sub: "I am a purple belt, and would love to train with you at Marcelo Garcia Academy.",
    arr: "MGA →",
    href: "https://marcelogarciajj.com/nyc/",
  },
];

// SVG path icons from johnrudolphdrexler.com
const SOCIALS = [
  {
    label: "Bluesky",
    href: "https://bsky.app/profile/johnrudolphdrexler.com",
    viewBox: "0 0 600 600",
    path: "m135.72 44.03c66.496 49.921 138.02 151.14 164.28 205.46 26.262-54.316 97.782-155.54 164.28-205.46 47.98-36.021 125.72-63.892 125.72 24.795 0 17.712-10.155 148.79-16.111 170.07-20.703 73.984-96.144 92.854-163.25 81.433 117.3 19.964 147.14 86.092 82.697 152.22-122.39 125.59-175.91-31.511-189.63-71.766-2.514-7.3797-3.6904-10.832-3.7077-7.8964-0.0174-2.9357-1.1937 0.51669-3.7077 7.8964-13.714 40.255-67.233 197.36-189.63 71.766-64.444-66.128-34.605-132.26 82.697-152.22-67.108 11.421-142.55-7.4491-163.25-81.433-5.9562-21.282-16.111-152.36-16.111-170.07 0-88.687 77.742-60.816 125.72-24.795z",
  },
  {
    label: "LinkedIn",
    href: "https://www.linkedin.com/in/jdrexler/",
    viewBox: "0 0 24 24",
    path: "M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z",
  },
  {
    label: "Spotify",
    href: "https://open.spotify.com/user/1236651355?si=cebd2689a5034a48",
    viewBox: "0 0 24 24",
    path: "M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z",
  },
  {
    label: "Twitter",
    href: "https://twitter.com/johnrudolphdrex",
    viewBox: "0 0 24 24",
    path: "M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84",
  },
  {
    label: "Instagram",
    href: "https://www.instagram.com/johnrudolphdrexler/",
    viewBox: "0 0 24 24",
    path: "M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z",
  },
  {
    label: "Letterboxd",
    href: "https://letterboxd.com/johnrudolphdrex/",
    viewBox: "0 0 500 500",
    // simplified: a circle + three dots, monochrome
    path: "M250 0C111.929 0 0 111.929 0 250s111.929 250 250 250 250-111.929 250-250S388.071 0 250 0zm-119 180a70 70 0 110 140 70 70 0 010-140zm119 0a70 70 0 110 140 70 70 0 010-140zm119 0a70 70 0 110 140 70 70 0 010-140z",
  },
];

Object.assign(window, { ERAS, VIDEOS, PODCASTS, BEYOND, SOCIALS });
