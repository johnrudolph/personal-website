function App() {
  const [scope, setScope] = React.useState("30-day assessment");

  return (
    <>
      <Nav />
      <main>
        <Hero />
        <TimelineSection />
        <Offerings onPickScope={setScope} />
        <VoiceSection />
        <Beyond />
        <Contact scope={scope} setScope={setScope} />
      </main>
      <Footer />
    </>
  );
}

ReactDOM.createRoot(document.getElementById("root")).render(<App />);
