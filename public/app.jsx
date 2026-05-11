function App() {
  return (
    <>
      <Nav />
      <main>
        <Hero />
        <TimelineSection />
        <Offerings />
        <VoiceSection />
        <Beyond />
        <Contact />
      </main>
      <Footer />
    </>
  );
}

ReactDOM.createRoot(document.getElementById("root")).render(<App />);
