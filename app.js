'use strict';
const menu=document.querySelector('.menu'),nav=document.querySelector('#nav');
function closeMenu(){if(!menu||!nav)return;nav.classList.remove('open');menu.setAttribute('aria-expanded','false');menu.setAttribute('aria-label','Open menu');}
menu?.addEventListener('click',()=>{const open=menu.getAttribute('aria-expanded')!=='true';menu.setAttribute('aria-expanded',String(open));menu.setAttribute('aria-label',open?'Close menu':'Open menu');nav.classList.toggle('open',open);});
nav?.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMenu));
document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeMenu();document.querySelectorAll('.nav-services[open]').forEach(x=>x.removeAttribute('open'));}});
document.addEventListener('click',e=>{document.querySelectorAll('.nav-services[open]').forEach(x=>{if(!x.contains(e.target))x.removeAttribute('open');});});
const service=document.querySelector('#service'),selected=new URLSearchParams(location.search).get('service');
if(service&&selected&&[...service.options].some(x=>x.value===selected))service.value=selected;

function parseSafeJson(raw){
  if(!raw||typeof raw!=='string') return null;
  try{ return JSON.parse(raw); }catch(e){}
  const firstBrace=raw.indexOf('{');
  const lastBrace=raw.lastIndexOf('}');
  if(firstBrace!==-1&&lastBrace>firstBrace){
    try{ return JSON.parse(raw.slice(firstBrace,lastBrace+1)); }catch(e){}
  }
  const match=raw.match(/\{[\s\S]*"success"[\s\S]*\}/);
  if(match){
    try{ return JSON.parse(match[0]); }catch(e){}
  }
  return null;
}

const form=document.querySelector('#brief-form');
if(form){
  const loadedInput=form.querySelector('[name="form_loaded_at"]');
  if(loadedInput) loadedInput.value=Date.now().toString();

  const urlParams=new URLSearchParams(window.location.search);
  const adSrc=form.querySelector('[name="ad_source"]');
  if(adSrc) adSrc.value=urlParams.get('utm_source')||urlParams.get('ad_source')||'';
  const srcTag=form.querySelector('[name="sourcetag"]');
  if(srcTag) srcTag.value=urlParams.get('sourcetag')||'';
  const utmCamp=form.querySelector('[name="utm_campaign"]');
  if(utmCamp) utmCamp.value=urlParams.get('utm_campaign')||'';

  form.addEventListener('submit',async e=>{
    e.preventDefault();
    if(!form.reportValidity()) return;

    const status=document.querySelector('#form-status');
    const submitBtn=form.querySelector('#submit-btn')||form.querySelector('button[type="submit"]');
    const originalBtnText=submitBtn?submitBtn.innerHTML:'Send Enquiry <span>↗</span>';

    if(submitBtn){
      submitBtn.disabled=true;
      submitBtn.innerHTML='Sending...';
    }
    if(status){
      status.style.color='#475569';
      status.textContent='Sending your enquiry...';
    }

    try{
      const SITE_KEY='6Le2RQMuAAAAALLD-lL1Wbb_GkYKLtK81bg848m3';
      let recaptchaToken='';
      if(typeof grecaptcha!=='undefined'&&grecaptcha.execute){
        try{
          recaptchaToken=await new Promise(resolve=>{
            const timer=setTimeout(()=>resolve(''),1500);
            grecaptcha.ready(async()=>{
              try{
                const t=await grecaptcha.execute(SITE_KEY,{action:'submit'});
                clearTimeout(timer);
                resolve(t||'');
              }catch(ex){
                clearTimeout(timer);
                resolve('');
              }
            });
          });
        }catch(err){
          console.warn('reCAPTCHA error:',err);
        }
      }

      const f=new FormData(form);
      if(recaptchaToken){
        f.set('recaptcha_token',recaptchaToken);
      }

      const actionUrl=form.getAttribute('action')||'send-inquiry.php';
      const response=await fetch(actionUrl,{
        method:'POST',
        body:f,
        headers:{'X-Requested-With':'XMLHttpRequest'}
      });

      const rawText=await response.text();
      const data=parseSafeJson(rawText);

      if(response.ok&&data&&data.success){
        if(status){
          status.style.color='#16a34a';
          status.textContent=data.message||'Thanks — redirecting...';
        }
        setTimeout(()=>{
          window.location.href='thankyou';
        },300);
      }else{
        const msg=(data&&data.message)?data.message:'Submission failed. Please check your details and try again.';
        if(status){
          status.style.color='#dc2626';
          status.textContent=msg;
        }
        if(submitBtn){
          submitBtn.disabled=false;
          submitBtn.innerHTML=originalBtnText;
        }
      }
    }catch(err){
      console.error('Submission error:',err);
      if(status){
        status.style.color='#dc2626';
        status.textContent='An unexpected error occurred. Please try again.';
      }
      if(submitBtn){
        submitBtn.disabled=false;
        submitBtn.innerHTML=originalBtnText;
      }
    }
  });
}
const filters=document.querySelectorAll('[data-filter]'),projects=document.querySelectorAll('[data-category]');
filters.forEach(button=>button.addEventListener('click',()=>{filters.forEach(b=>{const active=b===button;b.classList.toggle('active',active);b.setAttribute('aria-pressed',String(active));});const featured=button.dataset.filter==='featured';document.querySelector('.portfolio-grid')?.classList.toggle('featured-mode',featured);let count=0;projects.forEach(project=>{const show=featured?project.dataset.featured==='true':project.dataset.category===button.dataset.filter;project.hidden=!show;if(show)count++;});document.querySelector('#project-count').textContent=count+(featured?' featured projects':' project'+(count===1?'':'s'));}));

// Progressive motion: no libraries, scroll listeners or layout-changing effects.
(()=>{
 const preference=matchMedia('(prefers-reduced-motion: reduce)');
 const root=document.documentElement,hero=document.querySelector('.motion-hero'),toggle=document.querySelector('.motion-toggle');
 let paused=false,reveals;
 try{paused=sessionStorage.getItem('ait-motion-paused')==='true';}catch{}
 function sync(){
  const stopped=paused||preference.matches;
  root.classList.toggle('motion-paused',stopped);
  if(toggle){toggle.hidden=preference.matches;toggle.setAttribute('aria-pressed',String(paused));toggle.innerHTML=paused?'Play motion <span aria-hidden="true">▶</span>':'Pause motion <span aria-hidden="true">Ⅱ</span>';}
  if(stopped){reveals?.disconnect();document.querySelectorAll('.reveal-ready').forEach(el=>el.classList.add('is-visible'));}
 }
 toggle?.addEventListener('click',()=>{paused=!paused;try{sessionStorage.setItem('ait-motion-paused',String(paused));}catch{}sync();});
 preference.addEventListener('change',sync);sync();
 if('IntersectionObserver' in window){
  if(!paused&&!preference.matches){
   reveals=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('is-visible');reveals.unobserve(entry.target);}}),{threshold:0.08});
   document.querySelectorAll('.opening>div,.section-top,.service,.project,.software .wrap>h2,.product-lines a,.approach-copy,.feature-grid article,.step-list li,.faq details,.presence-grid article').forEach((el,i)=>{
    // Leave initial viewport content visible and only reveal content below it.
    if(el.getBoundingClientRect().top>innerHeight){el.style.setProperty('--reveal-delay',`${(i%3)*65}ms`);el.classList.add('reveal-ready');reveals.observe(el);}
   });
  }
  if(hero)new IntersectionObserver(entries=>{root.classList.toggle('motion-offscreen',!entries[0].isIntersecting);}).observe(hero);
 }
 document.addEventListener('visibilitychange',()=>root.classList.toggle('motion-offscreen',document.hidden));
})();

// Replay the launch sequence without reloading or changing scroll position.
const launch=document.querySelector('.launch-hero'),replay=document.querySelector('.launch-replay');
if(launch&&replay){
 replay.hidden=matchMedia('(prefers-reduced-motion: reduce)').matches;
 replay.addEventListener('click',()=>{
  if(document.documentElement.classList.contains('motion-paused'))document.querySelector('.motion-toggle')?.click();
  launch.classList.add('launch-restarting');
  requestAnimationFrame(()=>requestAnimationFrame(()=>launch.classList.remove('launch-restarting')));
 });
}

// Play each contextual scene when it actually enters the viewport (especially on phones).
const scenePreference=matchMedia('(prefers-reduced-motion: reduce)');
const sceneObserver='IntersectionObserver' in window?new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('scene-playing');sceneObserver.unobserve(entry.target);}}),{threshold:.25}):null;
document.querySelectorAll('[data-scene]').forEach(scene=>{
 const button=scene.querySelector('.scene-replay');
 if(button){button.hidden=scenePreference.matches;scenePreference.addEventListener('change',()=>button.hidden=scenePreference.matches);button.addEventListener('click',()=>{document.documentElement.classList.remove('motion-paused');try{sessionStorage.setItem('ait-motion-paused','false');}catch{}scene.classList.remove('scene-playing');requestAnimationFrame(()=>requestAnimationFrame(()=>scene.classList.add('scene-playing')));});}
 if(sceneObserver)sceneObserver.observe(scene);else scene.classList.add('scene-playing');
});

// A small hysteresis band prevents colour flicker around the scroll threshold.
const stickyHeader=document.querySelector('body>header');
if(stickyHeader){
 let scrolled=false,scrollQueued=false;
 function syncHeader(){
  const y=window.scrollY;
  scrolled=scrolled?y>24:y>64;
  stickyHeader.classList.toggle('is-scrolled',scrolled);
  scrollQueued=false;
 }
 window.addEventListener('scroll',()=>{if(!scrollQueued){scrollQueued=true;requestAnimationFrame(syncHeader);}},{passive:true});
 window.addEventListener('pageshow',syncHeader);
 syncHeader();
}

if(location.hash==='#software'){document.querySelector('[data-filter=software]')?.click();}

const demoSolution=new URLSearchParams(location.search).get('solution');
const demoNames={'varletpark':'VarletPark','blueforceops':'BlueForceOps','capnav':'CapNav','parkora':'Parkora','parkora-marine':'Parkora Marine','crm-software':'CRM Software','shortlist-pro':'Shortlist Pro'};
if(demoNames[demoSolution]&&document.querySelector('#message'))document.querySelector('#message').value='I would like a demonstration of '+demoNames[demoSolution]+'.\n\nOur requirements: ';

// Brochure Download Modal Handler
(function() {
  const openBtn = document.querySelector('#open-brochure-modal');
  const modal = document.querySelector('#brochure-modal');
  const closeBtn = document.querySelector('#close-brochure-modal');
  const backdrop = document.querySelector('#brochure-modal-backdrop');
  const form = document.querySelector('#brochure-form');
  const status = document.querySelector('#brochure-status');
  const submitBtn = document.querySelector('#brochure-submit-btn');
  const loadedAtInput = document.querySelector('#brochure-form-loaded-at');

  if (!modal || !openBtn) return;

  function openModal() {
    modal.classList.add('is-active');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    if (loadedAtInput) loadedAtInput.value = String(Date.now());
    setTimeout(() => {
      const firstInput = modal.querySelector('#brochure-name');
      if (firstInput) firstInput.focus();
    }, 100);
  }

  function setFieldError(input, msg) {
    if (!input) return;
    const parent = input.closest('.brochure-field');
    if (!parent) return;
    parent.classList.add('has-error');
    let errSpan = parent.querySelector('.brochure-field-error');
    if (errSpan) {
      errSpan.textContent = msg;
    }
  }

  function clearFieldErrors() {
    form.querySelectorAll('.brochure-field.has-error').forEach(field => {
      field.classList.remove('has-error');
      const errSpan = field.querySelector('.brochure-field-error');
      if (errSpan) errSpan.textContent = '';
    });
  }

  function closeModal() {
    modal.classList.remove('is-active');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    clearFieldErrors();
  }

  openBtn.addEventListener('click', (e) => {
    e.preventDefault();
    openModal();
  });

  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (backdrop) backdrop.addEventListener('click', closeModal);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('is-active')) {
      closeModal();
    }
  });

  if (form) {
    // Clear field errors as user types
    form.querySelectorAll('input, textarea').forEach(input => {
      input.addEventListener('input', () => {
        const parent = input.closest('.brochure-field');
        if (parent && parent.classList.contains('has-error')) {
          parent.classList.remove('has-error');
          const errSpan = parent.querySelector('.brochure-field-error');
          if (errSpan) errSpan.textContent = '';
        }
      });
    });

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      clearFieldErrors();

      let isValid = true;
      let firstInvalidInput = null;

      // 1. Full Name check
      const nameInput = form.querySelector('#brochure-name');
      if (nameInput) {
        const nameVal = nameInput.value.trim();
        if (!nameVal) {
          setFieldError(nameInput, 'Please enter your full name');
          isValid = false;
          if (!firstInvalidInput) firstInvalidInput = nameInput;
        }
      }

      // 2. Email Address check
      const emailInput = form.querySelector('#brochure-email');
      if (emailInput) {
        const emailVal = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailVal) {
          setFieldError(emailInput, 'Please enter your email address');
          isValid = false;
          if (!firstInvalidInput) firstInvalidInput = emailInput;
        } else if (!emailRegex.test(emailVal)) {
          setFieldError(emailInput, 'Please enter a valid email address');
          isValid = false;
          if (!firstInvalidInput) firstInvalidInput = emailInput;
        }
      }

      // 3. Phone / WhatsApp check
      const phoneInput = form.querySelector('#brochure-phone');
      if (phoneInput) {
        const phoneVal = phoneInput.value.trim();
        const phoneRegex = /^\+?[0-9\s\-()]{7,20}$/;
        if (phoneInput.hasAttribute('required') && !phoneVal) {
          setFieldError(phoneInput, 'Please enter your phone number');
          isValid = false;
          if (!firstInvalidInput) firstInvalidInput = phoneInput;
        } else if (phoneVal && !phoneRegex.test(phoneVal)) {
          setFieldError(phoneInput, 'Please enter a valid phone number');
          isValid = false;
          if (!firstInvalidInput) firstInvalidInput = phoneInput;
        }
      }

      if (!isValid) {
        if (firstInvalidInput) firstInvalidInput.focus();
        return;
      }

      // Pre-open new tab during user gesture so browser popup blockers do not block it
      let newTab = null;
      try {
        newTab = window.open('', '_blank');
      } catch (err) {}

      const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Processing...</span>';
      }
      if (status) {
        status.className = 'brochure-status';
        status.textContent = 'Submitting details...';
      }

      try {
        const formData = new FormData(form);
        const actionUrl = form.getAttribute('action') || 'send-brochure.php';

        const response = await fetch(actionUrl, {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const rawText = await response.text();
        const data = parseSafeJson(rawText);

        if (response.ok && data && data.success) {
          const rawUrl = form.dataset.brochureUrl || (data && data.brochure_url) || '%231%20Arabinfotec%20Company%20Profile%202026%20-%202027.pdf';
          let targetUrl = rawUrl;
          try {
            targetUrl = new URL(rawUrl, window.location.href).href;
          } catch (e) {
            targetUrl = rawUrl;
          }

          if (status) {
            status.className = 'brochure-status success';
            status.innerHTML = 'Thank you! Opening brochure in next tab...<br><a href="' + targetUrl + '" target="_blank" rel="noopener noreferrer" style="color:#7c3aed;text-decoration:underline;font-weight:600;font-size:12px;margin-top:6px;display:inline-block;">Click here if your browser blocked the new tab &nearrow;</a>';
          }
          if (submitBtn) {
            submitBtn.innerHTML = '<span>Opening brochure...</span>';
          }

          // Open brochure in next tab
          if (newTab && !newTab.closed) {
            newTab.location.href = targetUrl;
          } else {
            const a = document.createElement('a');
            a.href = targetUrl;
            a.target = '_blank';
            a.rel = 'noopener noreferrer';
            document.body.appendChild(a);
            a.click();
            a.remove();
          }

          setTimeout(() => {
            closeModal();
            form.reset();
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.innerHTML = originalBtnHtml;
            }
            if (status) {
              status.textContent = '';
            }
          }, 2500);
        } else {
          if (newTab && !newTab.closed) {
            newTab.close();
          }
          const errMsg = (data && data.message) ? data.message : 'Submission failed. Please check your details and try again.';
          if (status) {
            status.className = 'brochure-status error';
            status.textContent = errMsg;
          }
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHtml;
          }
        }
      } catch (err) {
        if (newTab && !newTab.closed) {
          newTab.close();
        }
        console.error('Brochure submission error:', err);
        if (status) {
          status.className = 'brochure-status error';
          status.textContent = 'An unexpected error occurred. Please try again.';
        }
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnHtml;
        }
      }
    });
  }
})();
