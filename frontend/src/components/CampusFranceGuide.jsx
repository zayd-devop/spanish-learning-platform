import React from 'react';

const CampusFranceGuide = () => {
  const steps = [
    {
      id: 1,
      title: '1. La Préparation (Septembre - Novembre)',
      icon: '📝',
      details: [
        'Passer un test de français : Le TCF TP (Test de Connaissance du Français) ou le DELF B2 est OBLIGATOIRE pour les étudiants marocains.',
        'Préparer son projet d\'études : Construire une lettre de motivation cohérente expliquant pourquoi vous souhaitez faire une L3 (Licence 3) après votre DTS OFPPT.',
        'Rassembler les documents : Relevés de notes originaux, diplôme du baccalauréat, attestation de réussite du DTS.'
      ],
      color: 'var(--accent-primary)'
    },
    {
      id: 2,
      title: '2. Création du Dossier "Études en France" (Octobre - Décembre)',
      icon: '💻',
      details: [
        'Créer un compte sur la plateforme pastel (Études en France).',
        'Saisir votre panier de formations : Vous avez droit à 7 choix de Licences. Privilégiez les Licences 3, ou Licences Pro liées au développement (MIAGE, Informatique).',
        'Payer les frais de dossier de Campus France Maroc aux agences du Crédit Agricole.',
        'Soumettre le dossier électronique avant la date limite (généralement fin décembre pour les Licences).'
      ],
      color: 'var(--accent-secondary)'
    },
    {
      id: 3,
      title: '3. L\'Entretien Pédagogique (Janvier - Février)',
      icon: '🗣️',
      details: [
        'Prendre rendez-vous avec un conseiller Campus France (Rabat, Casablanca, Marrakech, etc.).',
        'L\'entretien dure environ 20 minutes. Le conseiller évaluera votre niveau de français, votre motivation et la cohérence de votre projet (DTS OFPPT -> L3).',
        'Conseil : Montrez que vous maîtrisez les technologies demandées et que l\'alternance est votre objectif professionnel ultime.'
      ],
      color: '#f59e0b'
    },
    {
      id: 4,
      title: '4. Réponses et Recherche d\'Alternance (Mars - Juillet)',
      icon: '🤝',
      details: [
        'Réponses des universités : Les acceptations commencent à tomber au printemps.',
        'Faire son choix définitif sur la plateforme Études en France.',
        'Attention à l\'Alternance : En tant que primo-arrivant marocain, vous avez besoin d\'une Autorisation de Travail (APT) pour signer un contrat de professionnalisation ou d\'apprentissage. C\'est parfois complexe la première année. Assurez-vous que l\'université accepte de vous inscrire sous statut "Formation Initiale" le temps de trouver votre entreprise !'
      ],
      color: 'var(--success)'
    },
    {
      id: 5,
      title: '5. La Demande de Visa (Juin - Août)',
      icon: '🛂',
      details: [
        'Accord préalable : Vous recevrez une attestation d\'acceptation "Accord Préalable" de Campus France.',
        'Justificatifs financiers : Vous devez prouver que vous disposez de 615€ par mois (Attestation de Virement Irrévocable - AVI ou un garant solide en France/Maroc).',
        'Logement : Justificatif de domicile pour les 3 premiers mois en France.',
        'Rendez-vous TLS Contact : Dépôt du dossier de demande de Visa Long Séjour Valant Titre de Séjour (VLS-TS) étudiant.'
      ],
      color: '#ec4899'
    },
    {
      id: 6,
      title: '6. Arrivée en France (Septembre)',
      icon: '🛬',
      details: [
        'Validation du Visa : Dès votre arrivée, vous devez valider votre VLS-TS en ligne sur le site de l\'OFII.',
        'Inscription Administrative : Payer la CVEC (Contribution de Vie Étudiante et de Campus) et vous inscrire définitivement à votre université.',
        'Recherche d\'Alternance (Suite) : Si vous n\'avez pas encore d\'entreprise, c\'est le moment de participer aux forums entreprises de votre université.'
      ],
      color: '#14b8a6'
    }
  ];

  return (
    <div style={{ padding: '1rem', animation: 'fadeIn 0.5s ease-out' }}>
      <header style={{ marginBottom: '3rem', textAlign: 'center' }}>
        <h1 className="gradient-text" style={{ fontSize: '2.5rem', marginBottom: '1rem' }}>
          De l'OFPPT à la France 🇲🇦 ✈️ 🇫🇷
        </h1>
        <p style={{ color: 'var(--text-secondary)', fontSize: '1.1rem', maxWidth: '800px', margin: '0 auto' }}>
          Le guide complet étape par étape pour les diplômés OFPPT souhaitant poursuivre une Licence 3 en Alternance via Campus France.
        </p>
      </header>

      <section className="glass-panel" style={{ padding: '2.5rem', marginBottom: '3rem', background: 'rgba(59, 130, 246, 0.05)', borderLeft: '4px solid var(--accent-primary)' }}>
        <h3 style={{ color: 'var(--accent-primary)', marginBottom: '1rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
          </svg>
          À Savoir pour les Profils OFPPT
        </h3>
        <p style={{ color: 'var(--text-primary)', lineHeight: '1.7', fontSize: '1.05rem' }}>
          Le passage d'un Technicien Spécialisé (Bac+2) marocain vers une L3 en France est <strong>totalement possible</strong>, mais sélectif. Les universités recherchent des candidats ayant de solides compétences techniques, un bon niveau de français (B2 minimum), et un projet professionnel justifiant le besoin d'étudier en France. De plus, chercher une alternance depuis le Maroc est complexe : beaucoup d'étudiants commencent en formation initiale et basculent en alternance une fois sur le territoire français.
        </p>
      </section>

      <div className="timeline-container" style={{ position: 'relative', paddingLeft: '2rem', marginBottom: '4rem' }}>
        {/* Ligne verticale de la timeline */}
        <div className="timeline-line" style={{ position: 'absolute', top: 0, bottom: 0, left: '38px', width: '4px', background: 'var(--glass-border)', borderRadius: '2px' }}></div>

        <div style={{ display: 'flex', flexDirection: 'column', gap: '3rem' }}>
          {steps.map((step) => (
            <div key={step.id} className="timeline-item" style={{ position: 'relative', display: 'flex', gap: '2rem' }}>
              
              {/* Point de la timeline */}
              <div style={{ 
                width: '40px', height: '40px', borderRadius: '50%', background: step.color, 
                display: 'flex', alignItems: 'center', justifyContent: 'center', 
                fontSize: '1.2rem', color: 'white', zIndex: 2, flexShrink: 0,
                boxShadow: `0 0 15px ${step.color}40`, marginTop: '5px'
              }}>
                {step.icon}
              </div>

              {/* Contenu de l'étape */}
              <div className="glass-panel" style={{ flex: 1, padding: '2rem', borderTop: `4px solid ${step.color}` }}>
                <h3 style={{ fontSize: '1.4rem', color: 'var(--text-primary)', marginBottom: '1.5rem' }}>
                  {step.title}
                </h3>
                <ul style={{ listStyle: 'none', padding: 0, display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                  {step.details.map((detail, idx) => (
                    <li key={idx} style={{ display: 'flex', gap: '0.75rem', alignItems: 'flex-start' }}>
                      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke={step.color} style={{ flexShrink: 0, marginTop: '3px' }}>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span style={{ color: 'var(--text-secondary)', lineHeight: '1.6', fontSize: '1.05rem' }}>
                        {detail}
                      </span>
                    </li>
                  ))}
                </ul>
              </div>

            </div>
          ))}
        </div>
      </div>

      {/* --- NOUVELLE SECTION: ÉCOLES PRIVÉES --- */}
      <section className="glass-panel" style={{ padding: '2.5rem', marginBottom: '3rem', borderLeft: '4px solid #8b5cf6' }}>
        <h2 style={{ color: '#8b5cf6', marginBottom: '1.5rem', fontSize: '2rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
            <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
            <path d="M2 17l10 5 10-5M2 12l10 5 10-5"></path>
          </svg>
          L'Alternative : Les Écoles Privées (Titres RNCP)
        </h2>
        <p style={{ color: 'var(--text-secondary)', lineHeight: '1.7', fontSize: '1.1rem', marginBottom: '2rem' }}>
          De nombreux étudiants de l'OFPPT optent pour des écoles privées (souvent appelées "écoles d'ingénierie informatique"). Ces écoles ne délivrent pas de Licences universitaires, mais des <strong>Titres RNCP Niveau 6 (Bac+3)</strong> ou <strong>Niveau 7 (Bac+5)</strong>, très reconnus par les entreprises françaises.
        </p>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '2rem', marginBottom: '2rem' }}>
          <div style={{ background: 'rgba(0,0,0,0.03)', padding: '1.5rem', borderRadius: '12px' }}>
            <h4 style={{ color: 'var(--text-primary)', marginBottom: '1rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <span style={{ fontSize: '1.5rem' }}>⚡</span> Le Processus (Très Différent)
            </h4>
            <ul style={{ listStyle: 'none', padding: 0, display: 'flex', flexDirection: 'column', gap: '0.75rem', color: 'var(--text-secondary)' }}>
              <li><strong>1. Admission Directe :</strong> Vous postulez directement sur le site de l'école (toute l'année). Pas besoin d'attendre la procédure Études en France.</li>
              <li><strong>2. Tests de l'École :</strong> Vous passez leurs propres tests en ligne (logique, technique, anglais) et un entretien de motivation.</li>
              <li><strong>3. "Je suis accepté" :</strong> Une fois admis, vous allez sur Campus France et choisissez la procédure allégée "Je suis accepté" (juste pour valider le visa).</li>
            </ul>
          </div>

          <div style={{ background: 'rgba(0,0,0,0.03)', padding: '1.5rem', borderRadius: '12px' }}>
            <h4 style={{ color: 'var(--text-primary)', marginBottom: '1rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <span style={{ fontSize: '1.5rem' }}>💰</span> Frais et Alternance
            </h4>
            <ul style={{ listStyle: 'none', padding: 0, display: 'flex', flexDirection: 'column', gap: '0.75rem', color: 'var(--text-secondary)' }}>
              <li><strong>Coût :</strong> Les frais de scolarité varient de 6 000€ à 9 000€ par an.</li>
              <li><strong>L'Alternance :</strong> Si vous trouvez une entreprise, c'est elle qui paie vos frais de scolarité (et vous verse un salaire).</li>
              <li><strong>Le Risque :</strong> Si vous ne trouvez pas d'entreprise avant la rentrée, vous devrez payer l'école vous-même pour la première année en statut "Initial".</li>
            </ul>
          </div>
        </div>

        <h4 style={{ color: 'var(--text-primary)', marginBottom: '1rem', fontSize: '1.2rem' }}>Écoles populaires auprès des profils OFPPT :</h4>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '1rem' }}>
          {['Ynov Campus', 'Epitech', 'EPSI', 'MyDigitalSchool', 'CESI', 'Supinfo', 'Web@cademie', 'Campus Academy'].map(ecole => (
            <span key={ecole} style={{ background: 'rgba(139, 92, 246, 0.1)', color: '#8b5cf6', padding: '0.5rem 1rem', borderRadius: '8px', fontWeight: '600' }}>
              {ecole}
            </span>
          ))}
        </div>
      </section>

    </div>
  );
};

export default CampusFranceGuide;
