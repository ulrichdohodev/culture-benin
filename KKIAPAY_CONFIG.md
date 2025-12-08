# Configuration KKiaPay pour Culture Bénin

## Étapes pour intégrer KKiaPay

### 1. Créer un compte KKiaPay
- Rendez-vous sur https://kkiapay.me
- Créez un compte gratuit
- Activez votre compte via l'email de confirmation

### 2. Obtenir vos clés API
- Connectez-vous à votre dashboard KKiaPay
- Allez dans **Paramètres** > **API Keys**
- Copiez votre **Clé Publique** (Public Key) et votre **Clé Privée** (Private Key)

### 3. Configurer les clés dans le fichier .env

Ouvrez le fichier `.env` à la racine du projet et modifiez les lignes suivantes :

```env
# Mode Test (Sandbox)
KKIAPAY_PUBLIC_KEY=pk_test_votre_cle_publique_test
KKIAPAY_PRIVATE_KEY=sk_test_votre_cle_privee_test
KKIAPAY_SANDBOX=true
```

### 4. Passer en mode Production

Une fois que vous êtes prêt à accepter de vrais paiements :

```env
# Mode Production
KKIAPAY_PUBLIC_KEY=pk_live_votre_cle_publique_live
KKIAPAY_PRIVATE_KEY=sk_live_votre_cle_privee_live
KKIAPAY_SANDBOX=false
```

### 5. Configuration du Webhook (optionnel)

Pour recevoir les notifications de paiement :

1. Dans votre dashboard KKiaPay, allez dans **Webhooks**
2. Ajoutez l'URL : `https://votre-domaine.com/evenements/paiement/kkiapay/callback`
3. Sélectionnez les événements : **Payment Successful**

## Moyens de paiement supportés par KKiaPay

- ✅ MTN Mobile Money
- ✅ Moov Money  
- ✅ Cartes bancaires (Visa, Mastercard)
- ✅ Flooz (Moov Africa)

## Tarifs KKiaPay

KKiaPay prélève une commission sur chaque transaction :
- **Mobile Money** : 2% + 10 FCFA
- **Carte bancaire** : 3% + 25 FCFA

## Test en mode Sandbox

En mode test, utilisez ces numéros pour tester :

### MTN Mobile Money
- Numéro : 97000001
- Code : 0000

### Moov Money
- Numéro : 96000001
- Code : 0000

## Support

- Documentation KKiaPay : https://docs.kkiapay.me
- Support : support@kkiapay.me
- Téléphone : +229 69 00 00 00

## Sécurité

⚠️ **Important** :
- Ne partagez jamais votre clé privée (Private Key)
- Ne commitez jamais le fichier .env dans Git
- Utilisez toujours HTTPS en production
