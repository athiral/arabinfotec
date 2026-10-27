'use strict';
const menu=document.querySelector('.menu'),nav=document.querySelector('#nav');
function closeMenu(){if(!menu||!nav)return;nav.classList.remove('open');menu.setAttribute('aria-expanded','false');menu.setAttribute('aria-label','Open menu');}
menu?.addEventListener('click',()=>{const open=menu.getAttribute('aria-expanded')!=='true';menu.setAttribute('aria-expanded',String(open));menu.setAttribute('aria-label',open?'Close menu':'Open menu');nav.classList.toggle('open',open);});
nav?.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMenu));
document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeMenu();document.querySelectorAll('.nav-services[open]').forEach(x=>x.removeAttribute('open'));}});
document.addEventListener('click',e=>{document.querySelectorAll('.nav-services[open]').forEach(x=>{if(!x.contains(e.target))x.removeAttribute('open');});});
const service=document.querySelector('#service'),selected=new URLSearchParams(location.search).get('service');
if(service&&selected&&[...service.options].some(x=>x.value===selected))service.value=selected;
const form=document.querySelector('#brief-form');
form?.addEventListener('submit',e=>{e.preventDefault();if(!form.reportValidity())return;const f=new FormData(form);const body='Hello Arabinfotec,\n\nMy name is '+f.get('name')+'.\nCompany: '+(f.get('company')||'Not provided')+'\nEmail: '+f.get('email')+'\nInterested in: '+f.get('service')+'\n\n'+f.get('message')+'\n\nThank you.';const channel=e.submitter?.value||'email';const status=document.querySelector('#form-status');if(channel==='whatsapp'){const url='https://wa.me/971543697999?text='+encodeURIComponent(body);window.open(url,'_blank','noopener,noreferrer');status.textContent='Your brief is ready in WhatsApp. Review it and press Send there. If it did not open, allow pop-ups or use the WhatsApp contact link.';}else{location.href='mailto:hello@arabinfotec.com?subject='+encodeURIComponent('Project enquiry: '+f.get('service'))+'&body='+encodeURIComponent(body);status.textContent='Your email app will open with the brief. Review it and press Send there. You can also continue on WhatsApp.';}});
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
