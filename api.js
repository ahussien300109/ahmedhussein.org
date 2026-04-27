import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2/+esm';

// FIXED: Added .supabase.co to the URL
const SUPABASE_URL = 'https://zkjeldpnhvdxwpemofao.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpramVsZHBuaHZkeHdwZW1vZmFvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzcyNzI1NzcsImV4cCI6MjA5Mjg0ODU3N30.HVFMjm26hcscz2Vm2iVTIqp9AFagjTthRnRciXDx7nk';

const supabase = createClient(SUPABASE_URL, SUPABASE_KEY);

window.Api = {
  Courses: {
    list: async () => {
      console.log('[API] Fetching from Supabase...');
      try {
        const { data, error } = await supabase
          .from('courses')
          .select('*')
          .order('created_at', { ascending: false });
        
        if (error) {
          console.error('[API] Error:', error);
          return [];
        }
        console.log('[API] Success:', data);
        return data || [];
      } catch (e) {
        console.error('[API] Critical:', e);
        return [];
      }
    },
    get: async (id) => {
      try {
        const { data, error } = await supabase
          .from('courses')
          .select('*')
          .eq('id', id)
          .single();
        if (error) throw error;
        return data;
      } catch (e) {
        console.error('[API] Get Error:', e);
        return null;
      }
    }
  }
};