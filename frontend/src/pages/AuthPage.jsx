import { useState } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { BusFront, LockKeyhole, ShieldCheck, UserRound } from 'lucide-react';
import { useAuth } from '../context/AuthContext.jsx';

export default function AuthPage({ register = false }) {
  const [values, setValues] = useState({ name: '', email: '', password: '', password_confirmation: '' });
  const [errors, setErrors] = useState({});
  const [busy, setBusy] = useState(false);
  const [message, setMessage] = useState('');
  const { login, register: signup } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();

  async function submit(event) {
    event.preventDefault();
    const invalid = {};
    if (register && !values.name.trim()) invalid.name = ['Name is required.'];
    if (!/^\S+@\S+\.\S+$/.test(values.email)) invalid.email = ['Enter a valid email address.'];
    if (values.password.length < 8) invalid.password = ['Use at least 8 characters.'];
    if (register && values.password !== values.password_confirmation) {
      invalid.password_confirmation = ['Passwords do not match.'];
    }
    if (Object.keys(invalid).length) {
      setErrors(invalid);
      return;
    }

    setBusy(true);
    setErrors({});
    setMessage('');
    try {
      if (register) await signup(values);
      else await login({ email: values.email, password: values.password });
      navigate(location.state?.from || '/', { replace: true });
    } catch (error) {
      setErrors(error.response?.data?.errors || {});
      setMessage(error.response?.data?.message || 'Unable to sign in. Check your details and try again.');
    } finally {
      setBusy(false);
    }
  }

  if (register) {
    return (
      <main className="auth-screen auth-screen--register">
        <section className="auth-brand">
          <div className="brand-mark"><BusFront size={22} /></div>
          <div>sakay<span>local</span><small>COMMUNITY TRANSIT</small></div>
        </section>
        <AuthCard values={values} setValues={setValues} errors={errors} message={message} busy={busy} submit={submit} />
        <p className="auth-foot">SakayLocal · Bohol, Philippines</p>
      </main>
    );
  }

  return (
    <main className="auth-screen auth-screen--login">
      <section className="auth-brand">
        <div className="brand-mark"><BusFront size={22} /></div>
        <div>sakay<span>local</span><small>COMMUNITY TRANSIT</small></div>
      </section>
      <section className="auth-card auth-card--login">
          <div className="auth-icon"><ShieldCheck size={22} /></div>
          <div className="eyebrow">YOUR LOCAL RIDE COMPANION</div>
          <h1>Welcome back</h1>
          <p>Sign in to check routes and manage your queue.</p>
          {message && <div className="alert error-alert">{message}</div>}
          <form onSubmit={submit} noValidate>
            <AuthField
              label="Email address"
              name="email"
              type="email"
              placeholder="Email address"
              icon={UserRound}
              value={values.email}
              setValues={setValues}
              error={errors.email}
            />
            <AuthField
              label="Password"
              name="password"
              type="password"
              placeholder="Password"
              icon={LockKeyhole}
              value={values.password}
              setValues={setValues}
              error={errors.password}
            />
            <button className="primary-btn full-btn auth-login-button" disabled={busy}>
              {busy ? 'Please wait…' : 'Log In'}
            </button>
          </form>
          <div className="auth-switch">
            <span>Don’t have an account?</span>
            <Link to="/register">Register</Link>
          </div>
        </section>
      <p className="auth-foot">SakayLocal Â· Bohol, Philippines</p>
    </main>
  );
}

function AuthCard({ values, setValues, errors, message, busy, submit }) {
  return (
    <section className="auth-card">
      <div className="auth-icon"><ShieldCheck size={22} /></div>
      <div className="eyebrow">YOUR LOCAL RIDE COMPANION</div>
      <h1>Create your account</h1>
      <p>Join your local transit community.</p>
      {message && <div className="alert error-alert">{message}</div>}
      <form onSubmit={submit} noValidate>
        <AuthField label="Full name" name="name" value={values.name} setValues={setValues} error={errors.name} />
        <AuthField label="Email address" name="email" type="email" value={values.email} setValues={setValues} error={errors.email} />
        <AuthField label="Password" name="password" type="password" value={values.password} setValues={setValues} error={errors.password} />
        <AuthField
          label="Confirm password"
          name="password_confirmation"
          type="password"
          value={values.password_confirmation}
          setValues={setValues}
          error={errors.password_confirmation}
        />
        <button className="primary-btn full-btn" disabled={busy}>
          {busy ? 'Please wait…' : 'Create account'}
        </button>
      </form>
      <div className="auth-switch">Already have an account? <Link to="/login">Sign in</Link></div>
    </section>
  );
}

function AuthField({ label, name, type = 'text', placeholder, icon: Icon, value, setValues, error }) {
  return (
    <label className={`field ${Icon ? 'auth-login-field' : ''}`}>
      <span className={Icon ? 'sr-only' : ''}>{label}</span>
      {Icon && <Icon className="auth-field-icon" size={19} aria-hidden="true" />}
      <input
        type={type}
        autoComplete={name === 'password' ? 'current-password' : name === 'password_confirmation' ? 'new-password' : name}
        placeholder={placeholder}
        aria-label={label}
        value={value}
        onChange={event => setValues(current => ({ ...current, [name]: event.target.value }))}
      />
      {error?.map(item => <span className="field-error" key={item}>{item}</span>)}
    </label>
  );
}
